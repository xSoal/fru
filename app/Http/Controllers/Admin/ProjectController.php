<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Project;
use App\Models\ProjectCalendar;

use App\Models\Schedule;
use App\Models\ProjectExpedition;
use App\Models\ProjectLimit;
use App\Models\ProjectKPPItems;
class ProjectController extends Controller
{
    public function post(Project $project, Request $request){

        $input = $request->except('_token');

        //-----------------------------------------------------------------
        if( isset($input['save']) || isset($input['save_and_exit']) ){

            $project->fill($input);
            
            if( $project->save() ){

                if( isset($input['production_periods']) ){
                    foreach($input['production_periods'] as $k => $v){
                        $tmp = new ProjectCalendar;
                        $tmp['project_id'] = $project->id;
                        $tmp['production_periods'] = $v;
                        $tmp['start_production'] = $input['start_production'][$k];
                        $tmp['end_production'] = $input['end_production'][$k];
                        $tmp['day_count'] = '';
                        if( $input['start_production'][$k] != '' && $input['end_production'][$k] != '' ){
                            $datetime1 = new \DateTime($input['start_production'][$k]);
                            $datetime2 = new \DateTime($input['end_production'][$k]);
                            $interval = $datetime1->diff($datetime2);
                            $tmp['day_count'] = ($interval->format('%a')+1);
                        }

                        $tmp->save();
                    }
                }

                if( isset($input['save_and_exit']) ){
                    return redirect()->route('admin.project')->with('status','Додано');
                }else{
                    return redirect()->route('admin.addProject')->with('status','Додано');
                }
            }
        }
        //-----------------------------------------------------------------

        //-----------------------------------------------------------------
        if( isset($input['update']) || isset($input['update_and_exit']) ){

            $project = Project::find($input['id']); 
            $project->fill($input);

            if( $project->update() ){

                ProjectCalendar::where('project_id',$input['id'])->delete();
                if( isset($input['production_periods']) ){
                    foreach($input['production_periods'] as $k => $v){
                        $tmp = new ProjectCalendar;
                        $tmp['project_id'] = $project->id;
                        $tmp['production_periods'] = $v;
                        $tmp['start_production'] = $input['start_production'][$k];
                        $tmp['end_production'] = $input['end_production'][$k];

                        $tmp['day_count'] = '';
                        if( $input['start_production'][$k] != '' && $input['end_production'][$k] != '' ){
                            $datetime1 = new \DateTime($input['start_production'][$k]);
                            $datetime2 = new \DateTime($input['end_production'][$k]);
                            $interval = $datetime1->diff($datetime2);
                            $tmp['day_count'] = ($interval->format('%a')+1);
                        }
                        
                        $tmp->save();
                    }
                }

                if( isset($input['update_and_exit']) ){
                    return redirect()->route('admin.project')->with('status','Оновлено');
                }else{
                    return redirect()->route('admin.viewProject', ['id'=> $input['id'] ] )->with('status','Оновлено');
                }
            }
        }
        //-----------------------------------------------------------------


        //-----------------------------------------------------------------
        if( isset($input['updateSchedule'])  ){

            Schedule::where('project_id',$input['id'])->delete();
            foreach($input['master'] as $k => $v){
                $tmp = new Schedule;
                $tmp['project_id'] = $input['id'];
                $tmp['master'] = $v;
                $tmp['ether'] = $input['ether'][$k];
                $tmp['pre_master'] = $input['pre_master'][$k];
                $tmp->save();
            }

            return redirect()->back()->with('status','Збережено');
        }
        //-----------------------------------------------------------------


        //-----------------------------------------------------------------
        if( isset($input['updateExpedition'])  ){

            ProjectExpedition::where('project_id',$input['id'])->delete();
            foreach($input['route'] as $k => $v){
                $tmp = new ProjectExpedition;
                $tmp['project_id'] = $input['id'];
                $tmp['route'] = $v;
                $tmp['distance'] = $input['distance'][$k];
                $tmp['count_work_days'] = $input['count_work_days'][$k];
                $tmp['count_days'] = $input['count_days'][$k];
                $tmp['count_nights'] = $input['count_nights'][$k];
                $tmp->save();
            }

            return redirect()->back()->with('status','Збережено');
        }
        //-----------------------------------------------------------------

        //-----------------------------------------------------------------
        if( isset($input['updateLimit'])  ){

            $project = Project::find($input['id']); 
            $project->fill($input);
            $project->update();
            
            ProjectLimit::where('project_id',$input['id'])->delete();
            foreach($input['blockName'] as $k => $v){
                $tmp = new ProjectLimit;
                $tmp['project_id'] = $input['id'];
                $tmp['title'] = $v;
                
                $json = array();
                $sum = 0;
                
                for($i = 1; $i <= 15; $i++){
                    
                    $json['block_v'.$i] = $input['block_v'.$i][$k];

                    if( $i == 9 ){
                        foreach($input['block_v'.$i][$k] as $s){
                            $sum += $s;
                        }
                    }
                }
                
                $tmp['json'] = json_encode($json, JSON_UNESCAPED_UNICODE);;
                $tmp['sum'] = $sum;
                $tmp->save();
            }

            return redirect()->back()->with('status','Збережено');
        }
        //-----------------------------------------------------------------



        //-----------------------------------------------------------------
        if( isset($input['dell']) ){
            $tmp = Project::where('id',$input['id'])->first();
            $tmp->delete();
            return redirect()->route('admin.project')->with('status','Вилучено');
        }
        //-----------------------------------------------------------------

        //-----------------------------------------------------------------
        if( isset($input['search']) && $input['search']!=null ){
            if(view()->exists('admin.project.list')){
                $search = $input['search'];
                $paginate = 25;

                $genres = array();
                $tmp = Project::groupBy('genre')->get();
                foreach($tmp as $i){
                    $genres[] = $i->genres;
                }

                $formats = array();
                $tmp = Project::groupBy('format')->get();
                foreach($tmp as $i){
                    $formats[] = $i->formats;
                }

            
                $genre = isset($input['genre']) ? $input['genre'] : '';
                $format = isset($input['format']) ? $input['format'] : '';
                $search = isset($input['search']) ? $input['search'] : '';
                

                $items = Project::where('created_at','<>','');
                if( $format !='' || $genre !='' || $search !='' ){
                    if( $format !='' ){
                        $items = $items->where('format',$format);
                    }
                    if( $genre !='' ){
                        $items = $items->where('genre',$genre);
                    }
                    if( $search !='' ){
                        $items = $items->where('name', 'LIKE', '%'.$search.'%');
                    } 
                }
                $items = Project::paginate($paginate);

                
                if( $request['page']==null ){
                    $request['page'] = 1;
                }
                $page = $paginate * ($request['page']-1);

                $data = [
                        'title' => 'Проекти',
                        'search' => '',
                        'items' => $items,
                        'page' => $page,
                        'genre' => $genre,
                        'format' => $format,
                        'genres' => $genres,
                        'formats' => $formats,
				];
                return 	view('admin.project.list',$data);
            }
            abort(404);
        }
        //-----------------------------------------------------------------


        return redirect()->route('admin.post');
        
    }

    public function view($id){
		if(view()->exists('admin.project.edit') ){

            $item = Project::where('id', '=', $id)->first();

            $item->single = 0;
            if( $item->count_programs !=0 ){
                $item->single = round( $item->total_amount/ $item->count_programs );
            }
            $item->total_amount = number_format( $item->total_amount, 0, '.',' ');
            $item->single = number_format( $item->single, 0, '.',' ');
            
            $data = [
					'title' => 'Редагувати',
					'item' => $item,
				];
			return 	view('admin.project.edit',$data);
		}
        abort(404);
    }

    public function projectKPP($id){
		if(view()->exists('admin.project.kpp') ){

            $item = Project::where('id', '=', $id)->first();

            $start = $item->calendar[0]->start_production ?? '';
            $end = $item->calendar[0]->end_production ?? '';
            foreach($item->calendar as $cal){
                if( strtotime($start) > strtotime($cal->start_production) ){
                    $start = $cal->start_production;
                }
                if( strtotime($end) < strtotime($cal->end_production) ){
                    $end = $cal->end_production;
                }
            }

            $efir = array();
            foreach($item->schedule as $k => $cal){
                $efir[date('d.m.Y',strtotime( $cal->ether ))] = $k+1;
                if( strtotime($end) < strtotime($cal->ether) ){
                    $end = $cal->ether;
                }
            }


            $datetime1 = new \DateTime($start);
            $datetime2 = new \DateTime($end);
            $interval = $datetime1->diff($datetime2);
            $days = $interval->format('%a');
            
            $dateList = array();
            $dayOfWeek= array();
            $dayGoodView = array();
            $hol = array();
            for( $i = 0; $i <= $days; $i++ ){
                $day = date('d.m.Y',strtotime( $start." +$i Days" ));
                $k = date('Y-m-d',strtotime( $start." +$i Days" ));
                $dateList[$k] = $day;

                switch( date('N',strtotime( $day ) ) ) {
                    case 1: $dayOfWeek[ $day ] = "Пн" ; $hol[ $day ] = ''; break;
                    case 2: $dayOfWeek[ $day ] = "Вт" ; $hol[ $day ] = ''; break;
                    case 3: $dayOfWeek[ $day ] = "Ср" ; $hol[ $day ] = ''; break;
                    case 4: $dayOfWeek[ $day ] = "Чт" ; $hol[ $day ] = ''; break;
                    case 5: $dayOfWeek[ $day ] = "Пт" ; $hol[ $day ] = ''; break;
                    case 6: $dayOfWeek[ $day ] = "Сб" ; $hol[ $day ] = 'hol'; break;
                    case 7: $dayOfWeek[ $day ] = "Нд" ; $hol[ $day ] = 'hol'; break;
                }
            }

            $projectKPPitems = array();
            $tmp = ProjectKPPItems::where('project_id',$id)->get();
            foreach( $tmp as $i ){
                $i->json = json_decode($i->json,true);
                $projectKPPitems[ $i->row_id ][$i->count_id] = $i;
            }
           
            $data = [
					'title' => 'КПП',
					'item' => $item,
                    'start' => $start,
                    'end' => $end,
                    'days'=> $days,
                    'dateList' => $dateList,
                    'dayOfWeek' => $dayOfWeek,
                    'hol' => $hol,
                    'efir' => $efir,
                    'projectKPPitems' => $projectKPPitems
				];
			return 	view('admin.project.kpp',$data);
		}
        abort(404);
    }

    public function schedule($id){
		if(view()->exists('admin.project.schedule') ){

            $item = Project::where('id', '=', $id)->first();

            $data = [
					'title' => 'Графік сдачі програм',
					'item' => $item,
				];
			return 	view('admin.project.schedule',$data);
		}
        abort(404);
    }

    public function limit($id){
		if(view()->exists('admin.project.limit') ){

            $limits = array(

                        'Сценарне виробництво' =>
                        array(
                            'title' => 'Сценарне виробництво',
                            'json' => array(
                                'block_v1' => array('Сценарій (написання)','Біблія проекту (написання)','Презентація проекту','Сценарій (придбання прав)'),
                                'block_v2' => array(1,1,1,1),
                                'block_v3' => array('люд.','люд.','люд.','люд.'),
                                'block_v4' => array(1,1,1,1),
                                'block_v5' => array('сценарій','акордно','акордно','сценарій'),
                                'block_v6' => array(0,0,0,0),
                                'block_v7' => array(0,0,0,0),
                                'block_v8' => array(0,0,0,0),
                                'block_v9' => array(0,0,0,0),
                                'block_v10' => array('','','',''),
                                'block_v11' => array('','','',''),
                                'block_v12' => array('','','',''),
                                'block_v13' => array('','','',''),
                                'block_v14' => array('0%','0%','0%','0%'),
                                'block_v15' => array(0,0,0,0),
                            ),
                            'sum' => 0
                        ),

                        'Написання та придбання прав на музику' =>
                        array(
                            'title' => 'Написання та придбання прав на музику',
                            'json' => array(
                                'block_v1' => array('Написання тексту пісні (вірш)','Придбання прав на текст пісні (вірш)','Написання оригінальної музики (партитура)','Запис оригінальної музики (виконавців_вокалістів)','Запис оригінальної музики (гонорар музикантів)','Запис оригінальної музики (звукорежисер запису)','Запис оригінальної музики (оренда студії звукозапису)','Придбання прав на музику','Придбання прав на музичну бібліотеку'),
                                'block_v2' => array(1,1,1,1,1,1,1,1,1),
                                'block_v3' => array('люд.','люд.','люд.','люд.','люд.','люд.','люд.','проект','люд.'),
                                'block_v4' => array(1,1,1,1,1,1,1,1,1),
                                'block_v5' => array('пісня','пісня','муз.тема','муз.тема','зміна','зміна','зміна','пісня','акордно'),
                                'block_v6' => array(0,0,0,0,0,0,0,0,0),
                                'block_v7' => array(0,0,0,0,0,0,0,0,0),
                                'block_v8' => array(0,0,0,0,0,0,0,0,0),
                                'block_v9' => array(0,0,0,0,0,0,0,0,0),
                                'block_v10' => array('','','','','','','','',''),
                                'block_v11' => array('','','','','','','','',''),
                                'block_v12' => array('','','','','','','','',''),
                                'block_v13' => array('','','','','','','','',''),
                                'block_v14' => array('0%','0%','0%','0%','0%','0%','0%','0%','0%'),
                                'block_v15' => array(0,0,0,0,0,0,0,0,0),
                            ),
                            'sum' => 0
                        ),

                        'Придбання прав фото- відео матеріали' =>
                        array(
                            'title' => 'Придбання прав фото- відео матеріали',
                            'json' => array(
                                'block_v1' => array('Придбання прав (фото)','Придбання прав (відео)'),
                                'block_v2' => array(1,1),
                                'block_v3' => array('проект','проект'),
                                'block_v4' => array(1,1),
                                'block_v5' => array('од.','од.'),
                                'block_v6' => array(0,0),
                                'block_v7' => array(0,0),
                                'block_v8' => array(0,0),
                                'block_v9' => array(0,0),
                                'block_v10' => array('',''),
                                'block_v11' => array('',''),
                                'block_v12' => array('',''),
                                'block_v13' => array('',''),
                                'block_v14' => array('0%','0%'),
                                'block_v15' => array(0,0)
                            ),
                            'sum' => 0
                        ),

                        'Гонорари основного творчого складу (авторські права)' =>
                        array(
                            'title' => 'Гонорари основного творчого складу (авторські права)',
                            'json' => array(
                                'block_v1' => array('Режисер-постановник','Оператор-постановник','Художник-постановник'),
                                'block_v2' => array(1,1,1),
                                'block_v3' => array('люд.','люд.','люд.'),
                                'block_v4' => array(1,1,1),
                                'block_v5' => array('місяць','місяць','місяць'),
                                'block_v6' => array(0,0,0),
                                'block_v7' => array(0,0,0),
                                'block_v8' => array(0,0,0),
                                'block_v9' => array(0,0,0),
                                'block_v10' => array('','',''),
                                'block_v11' => array('','',''),
                                'block_v12' => array('','',''),
                                'block_v13' => array('','',''),
                                'block_v14' => array('0%','0%','0%'),
                                'block_v15' => array(0,0,0)
                            ),
                            'sum' => 0
                        ),

                        'Актори виконавці головних, другорядний, епізодичних ролей, масовка (авторські права)' =>
                        array(
                            'title' => 'Актори виконавці головних, другорядний, епізодичних ролей, масовка (авторські права)',
                            'json' => array(
                                'block_v1' => array('Головна роль 1','Головна роль 2','Головна роль 3','Другорядна роль 1','Другорядна роль 2','Другорядна роль 3','Епізодники','Актори масових сцен'),
                                'block_v2' => array(1,1,1,1,1,1,1,1),
                                'block_v3' => array('люд.','люд.','люд.','люд.','люд.','люд.','люд.','люд.'),
                                'block_v4' => array(1,1,1,1,1,1,1,1),
                                'block_v5' => array('зміна','зміна','зміна','зміна','зміна','зміна','зміна','зміна'),
                                'block_v6' => array(0,0,0,0,0,0,0,0),
                                'block_v7' => array(0,0,0,0,0,0,0,0),
                                'block_v8' => array(0,0,0,0,0,0,0,0),
                                'block_v9' => array(0,0,0,0,0,0,0,0),
                                'block_v10' => array('','','','','','','',''),
                                'block_v11' => array('','','','','','','',''),
                                'block_v12' => array('','','','','','','',''),
                                'block_v13' => array('','','','','','','',''),
                                'block_v14' => array('0%','0%','0%','0%','0%','0%','0%','0%'),
                                'block_v15' => array(0,0,0,0,0,0,0,0)
                            ),
                            'sum' => 0
                        ),


                        'Заробітна плата основного складу знімальної групи' =>
                        array(
                            'title' => 'Заробітна плата основного складу знімальної групи',
                            'json' => array(
                                'block_v1' => array('Креативний продюсер','Виконавчий продюсер','Асистент виконавчого продюсера (документообіг)','Лінійний продюсер / Директор проекту','Зам.директора (головний адміністратор)','Голова транспортного департаменту','Технічний продюсер ','Локейшн-менеджер','Адміністратор','Хелпер','Буфетниця (майданчик)','Кастинг-директор','Асистент кастинг-директора (зайнятість акторів)','Асистент по акторах (майданчик)','Головний редактор','Літературний редактор','Технічний редактор','Другий режисер (планування)','Другий режисер (майданчик)','Скриптсупервайзер','Асистент режисера-постановника (хлопушка)','Плейбек','Опертор / Камерамен','Асистент оператора (фокус)','Відеоінженер / механік','Оператор квадрокоптеру','Художник-декоратор','Асистент художника-постановника з реквізиту (підбір / закупка)','Реквізитор (майданчик)','Постановник','Художник по костюму','Асистент художника по костюму','Костюмер','Кастелянша','Художник з гриму','Гример','Художник по світлу (гаффер)','Чіф електрик','Освітлювач 1','Освітлювач 2','Освітлювач 3','Фотограф','Звукорежисер (майданчик)','Бум-оператор','Прибиральниця (локації / павільйон)','Медсестра','Охорона (локації / павільйон)','Поліцейські (охорона локації / павільйону)','Пожежники (зйомка екшн сцен / дощ)','Додаткові члени знімальної групи (доп.гримери, костюмери, непередбачувані)'),
                                'block_v2' => array(1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),
                                'block_v3' => array('люд.','люд.','люд.','люд.','люд.','люд.','люд.','люд.','люд.','люд.','люд.','люд.','люд.','люд.','люд.','люд.','люд.','люд.','люд.','люд.','люд.','люд.','люд.','люд.','люд.','люд.','люд.','люд.','люд.','люд.','люд.','люд.','люд.','люд.','люд.','люд.','люд.','люд.','люд.','люд.','люд.','люд.','люд.','люд.','люд.','люд.','люд.','люд.','люд.','люд.','люд.','люд.','люд.','люд.'),
                                'block_v4' => array(1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),
                                'block_v5' => array('місяць','місяць','місяць','місяць','місяць','місяць','місяць','місяць','місяць','місяць','місяць','місяць','місяць','місяць','місяць','місяць','місяць','місяць','місяць','місяць','місяць','місяць','місяць','місяць','місяць','місяць','місяць','місяць','місяць','місяць','місяць','місяць','місяць','місяць','місяць','місяць','зміна','зміна','зміна','зміна','зміна','зміна','зміна','зміна','місяць','місяць','зміна','зміна','зміна','зміна'),
                                'block_v6' => array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
                                'block_v7' => array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
                                'block_v8' => array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
                                'block_v9' => array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
                                'block_v10' => array('','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',''),
                                'block_v11' => array('','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',''),
                                'block_v12' => array('','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',''),
                                'block_v13' => array('','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',''),
                                'block_v14' => array('0%','0%','0%','0%','0%','0%','0%','0%','0%','0%','0%','0%','0%','0%','0%','0%','0%','0%','0%','0%','0%','0%','0%','0%','0%','0%','0%','0%','0%','0%','0%','0%','0%','0%','0%','0%','0%','0%','0%','0%','0%','0%','0%','0%','0%','0%','0%','0%','0%','0%','0%','0%','0%'),
                                'block_v15' => array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0)
                            ),
                            'sum' => 0
                        ),

                        'Кастинг' =>
                        array(
                            'title' => 'Кастинг',
                            'json' => array(
                                'block_v1' => array('Оренда студії','Оренда знімальної техніки (камера, світло, звук, пр.)','Оператор (гонорар)','Фотограф (гонорар)','Гример (гонорар)','Адміністратор (гонорар)','Кейтерінг (група + актори)','Непередбачувані витрати (компенсація витрат акторів на проїзд/проживання в Києві)'),
                                'block_v2' => array(1,1,1,1,1,1,1,1),
                                'block_v3' => array('проект','проект','люд.','люд.','люд.','люд.','проект','люд.'),
                                'block_v4' => array(1,1,1,1,1,1,1,1),
                                'block_v5' => array('зміна','зміна','зміна','зміна','зміна','зміна','порції','зміна'),
                                'block_v6' => array(0,0,0,0,0,0,0,0),
                                'block_v7' => array(0,0,0,0,0,0,0,0),
                                'block_v8' => array(0,0,0,0,0,0,0,0),
                                'block_v9' => array(0,0,0,0,0,0,0,0),
                                'block_v10' => array('','','','','','','',''),
                                'block_v11' => array('','','','','','','',''),
                                'block_v12' => array('','','','','','','',''),
                                'block_v13' => array('','','','','','','',''),
                                'block_v14' => array('0%','0%','0%','0%','0%','0%','0%','0%'),
                                'block_v15' => array(0,0,0,0,0,0,0,0)
                            ),
                            'sum' => 0
                        ),

                        'Експедиційні витрати' =>
                        array(
                            'title' => 'Експедиційні витрати',
                            'json' => array(
                                'block_v1' => array('Добові','Проживання групи','Проїзд групи (оренда легк.авто)','Проїзд групи (придбання палива А95)','Представницькі витрати / Непередбачувані витрати'),
                                'block_v2' => array(1,1,1,1,1),
                                'block_v3' => array('люд.','доба','авто','расход','проект'),
                                'block_v4' => array(1,1,1,1,1),
                                'block_v5' => array('зміна','зміна','зміна','км','зміна'),
                                'block_v6' => array(0,0,0,0,0),
                                'block_v7' => array(0,0,0,0,0),
                                'block_v8' => array(0,0,0,0,0),
                                'block_v9' => array(0,0,0,0,0),
                                'block_v10' => array('','','','',''),
                                'block_v11' => array('','','','',''),
                                'block_v12' => array('','','','',''),
                                'block_v13' => array('','','','',''),
                                'block_v14' => array('0%','0%','0%','0%','0%'),
                                'block_v15' => array(0,0,0,0,0)
                            ),
                            'sum' => 0
                        ),

                        'Оренда павільйону' =>
                        array(
                            'title' => 'Оренда павільйону',
                            'json' => array(
                                'block_v1' => array('Оренда павільйону','Комунальні платежі (оренда павільйону)','Охорона павільйону','Вивіз побутового мусору (павільйон)'),
                                'block_v2' => array(1,1,1,1),
                                'block_v3' => array('проект','проект','проект','проект'),
                                'block_v4' => array(1,1,1,1),
                                'block_v5' => array('зміна','місяць','місяць','місяць'),
                                'block_v6' => array(0,0,0,0),
                                'block_v7' => array(0,0,0,0),
                                'block_v8' => array(0,0,0,0),
                                'block_v9' => array(0,0,0,0),
                                'block_v10' => array('','','',''),
                                'block_v11' => array('','','',''),
                                'block_v12' => array('','','',''),
                                'block_v13' => array('','','',''),
                                'block_v14' => array('0%','0%','0%','0%'),
                                'block_v15' => array(0,0,0,0)
                            ),
                            'sum' => 0
                        ),

                        'Декорація' =>
                        array(
                            'title' => 'Декорація',
                            'json' => array(
                                'block_v1' => array('Розробка 3D моделей декорації (візуалізація)','Придбання будівельних матеріалів*','Транспортні послуги (закупка будівельних матеріалів)','Заробітна плата групи будівельників (будівництво декорації)','Придбання ігрових меблів (декорація)','Оренда ігрових меблів (декорація)','Придбання ігрового реквізиту (декорація)','Оренда ігрового реквізиту (декорація)','Драпірування','Транспортні послуги (вивіз будівельних матеріалів - мусор)','Оренда лаєру (освітлювальні ліси)'),
                                'block_v2' => array(1,1,1,1,1,1,1,1,1,1,1),
                                'block_v3' => array('люд.','проект','люд.','люд.','проект','проект','проект','проект','проект','люд.','люд.'),
                                'block_v4' => array(1,1,1,1,1,1,1,1,1,1,1),
                                'block_v5' => array('гонорар','акордно*','зміна','зміна','од.','од.','од.','од.','од.','зміна','зміна'),
                                'block_v6' => array(0,0,0,0,0,0,0,0,0,0,0),
                                'block_v7' => array(0,0,0,0,0,0,0,0,0,0,0),
                                'block_v8' => array(0,0,0,0,0,0,0,0,0,0,0),
                                'block_v9' => array(0,0,0,0,0,0,0,0,0,0,0),
                                'block_v10' => array('','','','','','','','','','',''),
                                'block_v11' => array('','','','','','','','','','',''),
                                'block_v12' => array('','','','','','','','','','',''),
                                'block_v13' => array('','','','','','','','','','',''),
                                'block_v14' => array('0%','0%','0%','0%','0%','0%','0%','0%','0%','0%','0%'),
                                'block_v15' => array(0,0,0,0,0,0,0,0,0,0,0),
                            ),
                            'sum' => 0
                        ),

                        'Друк банерів + поліграфія' =>
                        array(
                            'title' => 'Друк банерів + поліграфія',
                            'json' => array(
                                'block_v1' => array('Банер','Поліграфія'),
                                'block_v2' => array(1,1),
                                'block_v3' => array('проект','проект'),
                                'block_v4' => array(1,1),
                                'block_v5' => array('м2','од.'),
                                'block_v6' => array(0,0),
                                'block_v7' => array(0,0),
                                'block_v8' => array(0,0),
                                'block_v9' => array(0,0),
                                'block_v10' => array('',''),
                                'block_v11' => array('',''),
                                'block_v12' => array('',''),
                                'block_v13' => array('',''),
                                'block_v14' => array('0%','0%'),
                                'block_v15' => array(0,0)
                            ),
                            'sum' => 0
                        ),

                        'Оренда локацій' =>
                        array(
                            'title' => 'Оренда локацій',
                            'json' => array(
                                'block_v1' => array('Оренда натурних об\'єктів','Оренда інтер\'єрних об\'єктів','ОСБ','Інші дозволи на проведення зйомок (держустанови, тощо)'),
                                'block_v2' => array(1,1,1,1),
                                'block_v3' => array('проект','проект','проект','проект'),
                                'block_v4' => array(1,1,1,1),
                                'block_v5' => array('локація','локація','зміна','зміна'),
                                'block_v6' => array(0,0,0,0),
                                'block_v7' => array(0,0,0,0),
                                'block_v8' => array(0,0,0,0),
                                'block_v9' => array(0,0,0,0),
                                'block_v10' => array('','','',''),
                                'block_v11' => array('','','',''),
                                'block_v12' => array('','','',''),
                                'block_v13' => array('','','',''),
                                'block_v14' => array('0%','0%','0%','0%'),
                                'block_v15' => array(0,0,0,0)
                            ),
                            'sum' => 0
                        ),

                        'Декорування локацій' =>
                        array(
                            'title' => 'Декорування локацій',
                            'json' => array(
                                'block_v1' => array('Декорування натурних об\'єктів','Декорування інтер\'єрних об\'єктів'),
                                'block_v2' => array(1,1),
                                'block_v3' => array('проект','проект'),
                                'block_v4' => array(1,1),
                                'block_v5' => array('од','од.'),
                                'block_v6' => array(0,0),
                                'block_v7' => array(0,0),
                                'block_v8' => array(0,0),
                                'block_v9' => array(0,0),
                                'block_v10' => array('',''),
                                'block_v11' => array('',''),
                                'block_v12' => array('',''),
                                'block_v13' => array('',''),
                                'block_v14' => array('0%','0%'),
                                'block_v15' => array(0,0)
                            ),
                            'sum' => 0
                        ),

                        'Реквізит' =>
                        array(
                            'title' => 'Реквізит',
                            'json' => array(
                                'block_v1' => array('Ігровий реквізит','Вихідний реквізит'),
                                'block_v2' => array(1,1),
                                'block_v3' => array('проект','проект'),
                                'block_v4' => array(1,1),
                                'block_v5' => array('од','од.'),
                                'block_v6' => array(0,0),
                                'block_v7' => array(0,0),
                                'block_v8' => array(0,0),
                                'block_v9' => array(0,0),
                                'block_v10' => array('',''),
                                'block_v11' => array('',''),
                                'block_v12' => array('',''),
                                'block_v13' => array('',''),
                                'block_v14' => array('0%','0%'),
                                'block_v15' => array(0,0)
                            ),
                            'sum' => 0
                        ),

                        'Ігровий транспорт (оренда)' =>
                        array(
                            'title' => 'Ігровий транспорт (оренда)',
                            'json' => array(
                                'block_v1' => array('Авто головного героя','Авто другорядного героя','Непередбачувані витрати'),
                                'block_v2' => array(1,1,1),
                                'block_v3' => array('од.','од.','проект'),
                                'block_v4' => array(1,1,1),
                                'block_v5' => array('зміна','зміна','зміна'),
                                'block_v6' => array(0,0,0),
                                'block_v7' => array(0,0,0),
                                'block_v8' => array(0,0,0),
                                'block_v9' => array(0,0,0),
                                'block_v10' => array('','',''),
                                'block_v11' => array('','',''),
                                'block_v12' => array('','',''),
                                'block_v13' => array('','',''),
                                'block_v14' => array('0%','0%','0%'),
                                'block_v15' => array(0,0,0)
                            ),
                            'sum' => 0
                        ),

                        'Костюм' =>
                        array(
                            'title' => 'Костюм',
                            'json' => array(
                                'block_v1' => array('Пошив костюму (головні герої)','Придбання костюму (головні герої)','Оренда костюму (головні герої)','Пошив костюму (другорядні герої)','Придбання костюму (другорядні герої)','Оренда костюму (другорядні герої)','Придбання / оренда костюму (епізодники)','Придбання / оренда костюму (масовка)','Шкарпетки / колготки / мед.халати / маски / інше'),
                                'block_v2' => array(1,1,1,1,1,1,1,1,1),
                                'block_v3' => array('проект','проект','проект','проект','проект','проект','проект','проект','проект'),
                                'block_v4' => array(1,1,1,1,1,1,1,1,1),
                                'block_v5' => array('од.','од.','од.','од.','од.','од.','од.','од.','од.'),
                                'block_v6' => array(0,0,0,0,0,0,0,0,0),
                                'block_v7' => array(0,0,0,0,0,0,0,0,0),
                                'block_v8' => array(0,0,0,0,0,0,0,0,0),
                                'block_v9' => array(0,0,0,0,0,0,0,0,0),
                                'block_v10' => array('','','','','','','','',''),
                                'block_v11' => array('','','','','','','','',''),
                                'block_v12' => array('','','','','','','','',''),
                                'block_v13' => array('','','','','','','','',''),
                                'block_v14' => array('0%','0%','0%','0%','0%','0%','0%','0%','0%'),
                                'block_v15' => array(0,0,0,0,0,0,0,0,0),
                            ),
                            'sum' => 0
                        ),

                        'Грим' =>
                        array(
                            'title' => 'Грим',
                            'json' => array(
                                'block_v1' => array('Придбання гриму','Дозакупка гриму','Пастіж','Силіконовий грим','Штучна кров','Інші витратні матеріали гримерного цеху'),
                                'block_v2' => array(1,1,1,1,1,1),
                                'block_v3' => array('проект','проект','проект','проект','проект','проект'),
                                'block_v4' => array(1,1,1,1,1,1),
                                'block_v5' => array('комплект','місяць','од.','од.','мл./літр','од.'),
                                'block_v6' => array(0,0,0,0,0,0),
                                'block_v7' => array(0,0,0,0,0,0),
                                'block_v8' => array(0,0,0,0,0,0),
                                'block_v9' => array(0,0,0,0,0,0),
                                'block_v10' => array('','','','','',''),
                                'block_v11' => array('','','','','',''),
                                'block_v12' => array('','','','','',''),
                                'block_v13' => array('','','','','',''),
                                'block_v14' => array('0%','0%','0%','0%','0%','0%'),
                                'block_v15' => array(0,0,0,0,0,0)
                            ),
                            'sum' => 0
                        ),

                        'Піротехнічні послуги, матеріали та зброя' =>
                        array(
                            'title' => 'Піротехнічні послуги, матеріали та зброя',
                            'json' => array(
                                'block_v1' => array('Піротехніка','Сніг машина','Постановка та виконання трюків'),
                                'block_v2' => array(1,1,1),
                                'block_v3' => array('проект','проект','проект'),
                                'block_v4' => array(1,1,1),
                                'block_v5' => array('зміна','зміна','трюк'),
                                'block_v6' => array(0,0,0),
                                'block_v7' => array(0,0,0),
                                'block_v8' => array(0,0,0),
                                'block_v9' => array(0,0,0),
                                'block_v10' => array('','',''),
                                'block_v11' => array('','',''),
                                'block_v12' => array('','',''),
                                'block_v13' => array('','',''),
                                'block_v14' => array('0%','0%','0%'),
                                'block_v15' => array(0,0,0)
                            ),
                            'sum' => 0
                        ),

                        'Оренда тварин, дресура' =>
                        array(
                            'title' => 'Оренда тварин, дресура',
                            'json' => array(
                                'block_v1' => array('Оренда тварин, дресура'),
                                'block_v2' => array(1),
                                'block_v3' => array('од.'),
                                'block_v4' => array(1),
                                'block_v5' => array('зміна'),
                                'block_v6' => array(0),
                                'block_v7' => array(0),
                                'block_v8' => array(0),
                                'block_v9' => array(0),
                                'block_v10' => array(''),
                                'block_v11' => array(''),
                                'block_v12' => array(''),
                                'block_v13' => array(''),
                                'block_v14' => array('0%'),
                                'block_v15' => array(0)
                            ),
                            'sum' => 0
                        ),

                        'Послуги держ. установ та органів правопорядку' =>
                        array(
                            'title' => 'Послуги держ. установ та органів правопорядку',
                            'json' => array(
                                'block_v1' => array('Оплата працівників ДПС','Оплата працівників міліції','Оплата працівників МНС'),
                                'block_v2' => array(1,1,1),
                                'block_v3' => array('проект','проект','проект'),
                                'block_v4' => array(1,1,1),
                                'block_v5' => array('зміна','зміна','зміна'),
                                'block_v6' => array(0,0,0),
                                'block_v7' => array(0,0,0),
                                'block_v8' => array(0,0,0),
                                'block_v9' => array(0,0,0),
                                'block_v10' => array('','',''),
                                'block_v11' => array('','',''),
                                'block_v12' => array('','',''),
                                'block_v13' => array('','',''),
                                'block_v14' => array('0%','0%','0%'),
                                'block_v15' => array(0,0,0)
                            ),
                            'sum' => 0
                        ),

                        'Оренда знімальної техніки' =>
                        array(
                            'title' => 'Оренда знімальної техніки',
                            'json' => array(
                                'block_v1' => array('Камери*','Спеціальні операторські засоби*','Освітлення*','Звук*','Комплект рацій (оренда / покупка)','Придбання світло.фільтрів'),
                                'block_v2' => array(1,1,1,1,1,1),
                                'block_v3' => array('проект','проект','проект','проект','проект','проект'),
                                'block_v4' => array(1,1,1,1,1,1),
                                'block_v5' => array('зміна','зміна','зміна','зміна','од.','місяць'),
                                'block_v6' => array(0,0,0,0,0,0),
                                'block_v7' => array(0,0,0,0,0,0),
                                'block_v8' => array(0,0,0,0,0,0),
                                'block_v9' => array(0,0,0,0,0,0),
                                'block_v10' => array('','','','','',''),
                                'block_v11' => array('','','','','',''),
                                'block_v12' => array('','','','','',''),
                                'block_v13' => array('','','','','',''),
                                'block_v14' => array('0%','0%','0%','0%','0%','0%'),
                                'block_v15' => array(0,0,0,0,0,0)
                            ),
                            'sum' => 0
                        ),

                        'Транспорт (оренда)' =>
                        array(
                            'title' => 'Транспорт (оренда)',
                            'json' => array(
                                'block_v1' => array('Авто - адміністрація','Авто - режисер-постановник','Авто - оператор-постановник','Авто - актори','Авто - художники (ігровий реквізит - закупка)','Авто - художники (ігровий реквізит - майданчик)','Авто - грим / костюму','Авто - АХЧ','Авто - знімальна група','Старваген','Гримваген','Мобільний туалет','Генератор','Скай-ліфт','ГСМ для транспорту проекта','ГСМ (компенсація витрат головам департаментів)','Таксі (ранній збір групи / розвозка наприкінці зміни)'),
                                'block_v2' => array(1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),
                                'block_v3' => array('авто','авто','авто','авто','авто','авто','авто','авто','авто','авто','авто','авто','авто','авто','авто','люд.','проект'),
                                'block_v4' => array(1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),
                                'block_v5' => array('зміна','зміна','зміна','зміна','зміна','зміна','зміна','зміна','зміна','зміна','зміна','зміна','зміна','зміна','зміна','зміна','зміна'),
                                'block_v6' => array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
                                'block_v7' => array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
                                'block_v8' => array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
                                'block_v9' => array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
                                'block_v10' => array('','','','','','','','','','','','','','','','',''),
                                'block_v11' => array('','','','','','','','','','','','','','','','',''),
                                'block_v12' => array('','','','','','','','','','','','','','','','',''),
                                'block_v13' => array('','','','','','','','','','','','','','','','',''),
                                'block_v14' => array('0%','0%','0%','0%','0%','0%','0%','0%','0%','0%','0%','0%','0%','0%','0%','0%','0%'),
                                'block_v15' => array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
                            ),
                            'sum' => 0
                        ),

                        'Харчування членів знімальної групи' =>
                        array(
                            'title' => 'Харчування членів знімальної групи',
                            'json' => array(
                                'block_v1' => array('Кейтерінг (актори)','Кейтерінг (група)','Буфет (актори)','Буфет (група)','Вода','Одноразовий посуд','Бутерброди (рання зміна)'),
                                'block_v2' => array(1,1,1,1,1,1,1),
                                'block_v3' => array('люд.','люд.','люд.','люд.','проект','проект','проект'),
                                'block_v4' => array(1,1,1,1,1,1,1),
                                'block_v5' => array('зміна','зміна','зміна','зміна','од.','од.','зміна'),
                                'block_v6' => array(0,0,0,0,0,0,0),
                                'block_v7' => array(0,0,0,0,0,0,0),
                                'block_v8' => array(0,0,0,0,0,0,0),
                                'block_v9' => array(0,0,0,0,0,0,0),
                                'block_v10' => array('','','','','','',''),
                                'block_v11' => array('','','','','','',''),
                                'block_v12' => array('','','','','','',''),
                                'block_v13' => array('','','','','','',''),
                                'block_v14' => array('0%','0%','0%','0%','0%','0%','0%'),
                                'block_v15' => array(0,0,0,0,0,0,0)
                            ),
                            'sum' => 0
                        ),

                        'Витрати періоду постпродакшн' =>
                        array(
                            'title' => 'Витрати періоду постпродакшн',
                            'json' => array(
                                'block_v1' => array('Менеджер пост-продакшн','Головний режисер монтажа','Монтаж (чорновий/чистовий монтаж)','Звук (чистка реплік, накладання шумів, музичне оформлення, зведення)','Графіка (CGI/VFX)','Кольорокорекція','Відеоінженер (супроводження зйомок + пост)','Системний адміністратор','Створення початкових та фінальних ігрових титрів проекту','Складання монтажних / діалогових листів','Складання музичних довідок'),
                                'block_v2' => array(1,1,1,1,1,1,1,1,1,1,1),
                                'block_v3' => array('проект','проект','проект','проект','проект','проект','проект','проект','проект','проект','проект'),
                                'block_v4' => array(1,1,1,1,1,1,1,1,1,1,1),
                                'block_v5' => array('епізод','епізод','епізод','епізод','епізод','епізод','епізод','епізод','епізод','епізод','епізод'),
                                'block_v6' => array(0,0,0,0,0,0,0,0,0,0,0),
                                'block_v7' => array(0,0,0,0,0,0,0,0,0,0,0),
                                'block_v8' => array(0,0,0,0,0,0,0,0,0,0,0),
                                'block_v9' => array(0,0,0,0,0,0,0,0,0,0,0),
                                'block_v10' => array('','','','','','','','','','',''),
                                'block_v11' => array('','','','','','','','','','',''),
                                'block_v12' => array('','','','','','','','','','',''),
                                'block_v13' => array('','','','','','','','','','',''),
                                'block_v14' => array('0%','0%','0%','0%','0%','0%','0%','0%','0%','0%','0%'),
                                'block_v15' => array(0,0,0,0,0,0,0,0,0,0,0)
                            ),
                            'sum' => 0
                        ),

                        'Непередбачувані витрати (проект)' =>
                        array(
                            'title' => 'Непередбачувані витрати (проект)',
                            'json' => array(
                                'block_v1' => array('Непередбачувані витрати (проект)'),
                                'block_v2' => array(1),
                                'block_v3' => array('проект'),
                                'block_v4' => array(1),
                                'block_v5' => array('епізод'),
                                'block_v6' => array(0),
                                'block_v7' => array(0),
                                'block_v8' => array(0),
                                'block_v9' => array(0),
                                'block_v10' => array(''),
                                'block_v11' => array(''),
                                'block_v12' => array(''),
                                'block_v13' => array(''),
                                'block_v14' => array('0%'),
                                'block_v15' => array(0)
                            ),
                            'sum' => 0
                        ),
                        
            );

            $item = Project::where('id', '=', $id)->first();

            foreach($item->limit as $limit){
                $limit->json = json_decode($limit->json,true);
                if( isset($limits[$limit->title]) ){
                    $limits[$limit->title]['json'] = $limit->json;
                }else{
                    $limits[] = array('title' => $limit->title, 'json' => $limit->json, 'sum' => $limit->title);
                }
            }
            
            $data = [
					'title' => 'Ліміт затрат',
					'item' => $item,
                    'limits' => $limits
				];
			return 	view('admin.project.limit',$data);
		}
        abort(404);
    }

    public function expedition($id){
		if(view()->exists('admin.project.expedition') ){

            $item = Project::where('id', '=', $id)->first();
            
            $data = [
					'title' => 'Експедиція/проживання',
					'item' => $item,
				];
			return 	view('admin.project.expedition',$data);
		}
        abort(404);
    }


    public function add(Request $request){
		if(view()->exists('admin.project.edit') ){
            $data = [
                'title' => 'Додати',
                ];
			return 	view('admin.project.edit',$data);
		}
		abort(404);
	}

    public function list(Request $request){
		if(view()->exists('admin.project.list') ){
            $input = $request->except('_token');

            $paginate = 25;

            $genres = array();
            $tmp = Project::where('created_at','<>','')->groupBy('genre')->get();
            foreach($tmp as $i){
                $genres[] = $i->genre;
            }
           
            $formats = array();
            $tmp = Project::where('created_at','<>','')->groupBy('format')->get();
            foreach($tmp as $i){
                $formats[] = $i->format;
            }

          
            $genre = isset($input['genre']) ? $input['genre'] : '';
            $format = isset($input['format']) ? $input['format'] : '';
            $search = isset($input['search']) ? $input['search'] : '';
            

            $items = Project::where('created_at','<>','');
            if( $format !='' || $genre !='' || $search !='' ){
                if( $format !='' ){
                    $items = $items->where('format',$format);
                }
                if( $genre !='' ){
                    $items = $items->where('genre',$genre);
                }
                if( $search !='' ){
                    $items = $items->where('name', 'LIKE', '%'.$search.'%');
                } 
            }
            $items = Project::paginate($paginate);

            
			if( $request['page']==null ){
				$request['page'] = 1;
			}
			$page = $paginate * ($request['page']-1);
			
            
            $data = [
					'title' => 'Проекти',
                    'search' => '',
                    'items' => $items,
                    'page' => $page,
                    'genre' => $genre,
                    'format' => $format,
                    'genres' => $genres,
                    'formats' => $formats,
				];
			return 	view('admin.project.list',$data);
		}
		abort(404);
	}
}
