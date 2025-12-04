@extends('layouts.company_admin')

@section('content')

<div class="page-container neo-card details-page">

  <div class="buttonBackCont">
      <a href="/">< to site</a>
  </div>
  @include('client_admin.menu')



  <hr class="separator"/>
  <section class="request-table-section">
      <h2 class="section-subtitle">EQUIPMENT REQUEST</h2>
      <div class="responsive-table">
          <table>
              <thead>
                  <tr>
                      <th>№</th>
                      <th>NAME</th>
                      <th>MODEL</th>
                      <th>MANUFACTURER</th>
                      <th>COUNTRY</th>
                      <th>QUANTITY</th>
                      <th>STATUS</th>
                      @if( (int)Auth::user()->role === 0 )
                      <th></th>
                      @endif
                  </tr>
              </thead>
              <tbody>
                  @foreach ($equipmentRequests as $e )
                    <tr>
                      <td class="code">{{ $e->code }}</td>
                      <td class="name">{{ $e->name }}</td>
                      <td class="model">{{ $e->model }}</td>
                      <td class="manufacturer">{{ $e->manufacturer }}</td>
                      <td class="country">{{ $e->country }}</td>
                      <td class="quantity">{{ $e->quantity }}</td>
                      @if( (int)Auth::user()->role === 0 )
                      <td class="status">
                        {{-- {{ $e->active ? 'active' : 'disabled'  }} --}}
                        @csrf
                        <label class="switch">
                          <input type="checkbox" 
                                  class="status-toggle" 
                                  data-id="{{ $e->id }}"
                                  {{ (int)$e->active === 1 ? 'checked' : '' }}>
                            
                            <span class="slider round"></span>
                        </label>
                        <span style="display: none"  class="status-label" id="status-label-{{ $e->id }}">
                            {{ $e->active === 'active' ? 'Активний' : 'Неактивний' }}
                        </span>
                      
                      </td>
                      <td>
                        <span class="editButton neo-bg-accent" data-id="{{ $e->id }}">edit</span>
                      </td>
                      @else
                      <td class="status">
                        {{ (int)$e->active === 1 ? 'active' : 'disabled' }}
                      </td>
                      @endif
                    </tr>  
                  @endforeach
                  @if( (int)Auth::user()->role === 0 )
                  <tr>
                    <td colspan="6">
                      <button class="submit-button neo-bg-accent addRequest">ADD EQUIPMENT REQUEST</button>
                    </td>          
                  </tr>
                  @endif
              </tbody>
          </table>
          <div class="addRequestForm">
            <div class="request-form-controls">
              <h2 class="section-subtitle">ADD REQUEST</h2>
              <form action="{{ route('admin.clientAdminAddRequest') }}" method="post">
                  @csrf
                  <div id="new-request-row" class="neo-input-row">
            
                    <div class="input-cell cell-name">
                        <span class="label-text">NAME</span>
                        <input type="text" name="name" required placeholder="Input name" class="table-input">
                    </div>
            
                    <div class="input-cell cell-model">
                        <span class="label-text">MODEL</span>
                        <input type="text" name="model" required placeholder="Input model" class="table-input">
                    </div>
            
                    <div class="input-cell cell-manufacturer">
                        <span class="label-text">MANUFACTURER</span>
                        <input type="text" name="manufacturer" required placeholder="Input manufacturer" class="table-input">
                    </div>

                    <div class="input-cell cell-active">
                        <span class="label-text">IS ACTIVE</span>
                        <input type="checkbox" name="active" placeholder="" style="width: auto;">
                    </div>
            
                    <div class="input-cell cell-country">
                        <span class="label-text">COUNTRY</span>
                        {{-- <input type="text" name="country" required placeholder="Input country" class="table-input"> --}}
                        <select  name="country" required placeholder="Input country" class="table-input">
                          <option value="Austria">Austria</option>
                          <option value="Belgium">Belgium</option>
                          <option value="Canada">Canada</option>
                          <option value="Czechia">Czechia</option>
                          <option value="Denmark">Denmark</option>
                          <option value="Finland">Finland</option>
                          <option value="France">France</option>
                          <option value="Germany">Germany</option>
                          <option value="Italy">Italy</option>
                          <option value="Japan">Japan</option>
                          <option value="Netherlands">Netherlands</option>
                          <option value="Poland">Poland</option>
                          <option value="Portugal">Portugal</option>
                          <option value="Spain">Spain</option>
                          <option value="Sweden">Sweden</option>
                          <option value="Switzerland">Switzerland</option>
                          <option value="Ukraine">Ukraine</option>
                          <option value="United Kingdom">United Kingdom</option>
                          <option value="USA">USA</option>
                        </select>
                    </div>
            
                    <div class="input-cell cell-quantity">
                        <span class="label-text">QUANTITY</span>
                        <input type="number" name="quantity" required placeholder="Input quantity" min="1" value="1" class="table-input input-number">
                    </div>
                  </div>
                
                <button id="add-equipment-btn" class="neo-add-btn neo-bg-accent">
                    + ADD EQUIPMENT REQUEST
                </button>
              </form>

            </div>
          </div>
          <div class="editRequestForm">
            <div class="request-form-controls">
              <h2 class="section-subtitle">EDIT REQUEST</h2>
              <form action="{{ route('admin.clientAdminEditRequest') }}" method="post">
                  @csrf
                  <div id="new-request-row" class="neo-input-row">
                    <input hidden name="id" value="" class="editRequestId">
                    <div class="input-cell cell-name">
                      <span class="label-text">№</span>
                      <input disabled required type="text" name="code" placeholder="N" class="table-input">
                  </div>
                    <div class="input-cell cell-name">
                        <span class="label-text">NAME</span>
                        <input type="text" name="name" required placeholder="" class="table-input">
                    </div>
            
                    <div class="input-cell cell-model">
                        <span class="label-text">MODEL</span>
                        <input type="text" name="model" required placeholder="" class="table-input">
                    </div>
            
                    <div class="input-cell cell-manufacturer">
                        <span class="label-text">MANUFACTURER</span>
                        <input type="text" name="manufacturer" required placeholder="" class="table-input">
                    </div>

                    {{-- <div class="input-cell cell-active">
                        <span class="label-text">IS ACTIVE</span>
                        <input type="checkbox" name="active" placeholder="" style="width: auto;">
                    </div> --}}
            
                    <div class="input-cell cell-country">
                        <span class="label-text">COUNTRY</span>
                        <select  name="country" required placeholder="Input " class="table-input country">
                          <option value="Austria">Austria</option>
                          <option value="Belgium">Belgium</option>
                          <option value="Canada">Canada</option>
                          <option value="Czechia">Czechia</option>
                          <option value="Denmark">Denmark</option>
                          <option value="Finland">Finland</option>
                          <option value="France">France</option>
                          <option value="Germany">Germany</option>
                          <option value="Italy">Italy</option>
                          <option value="Japan">Japan</option>
                          <option value="Netherlands">Netherlands</option>
                          <option value="Poland">Poland</option>
                          <option value="Portugal">Portugal</option>
                          <option value="Spain">Spain</option>
                          <option value="Sweden">Sweden</option>
                          <option value="Switzerland">Switzerland</option>
                          <option value="Ukraine">Ukraine</option>
                          <option value="United Kingdom">United Kingdom</option>
                          <option value="USA">USA</option>
                        </select>
                    </div>
            
                    <div class="input-cell cell-quantity">
                        <span class="label-text">QUANTITY</span>
                        <input type="number" name="quantity" required placeholder="" min="1" value="1" class="table-input input-number">
                    </div>
                  </div>
                
                <button id="edit-equipment-btn" class="neo-add-btn neo-bg-accent">
                    + EDIT EQUIPMENT REQUEST
                </button>
              </form>

            </div>
          </div>
      </div>
  </section>

  <hr class="separator"/>

</div>


@endsection