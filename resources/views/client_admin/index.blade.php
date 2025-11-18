@extends('layouts.company_admin')

@section('content')

<div class="page-container neo-card details-page">
  <div class="messageCont">
    <button class="messages-button neo-accent-btn">
        <span class="icon-indicator">4</span>
        MESSAGES
    </button>
  </div>

  <header class="header">
      <h1 class="page-title details-title">
        <span class="neo-highlight">Name</span> {{ $client->name }}
      </h1>
  </header>

  <section class="partner-details-info">
      <div class="logo-placeholder neo-bg-accent">
          {{ $client->photo }}
      </div>
      <div class="partner-name-placeholder">
          
      </div>
  </section>
  

  <hr class="separator"/>
  <section class="request-table-section">
      <h2 class="section-subtitle">EQUIPMENT REQUEST</h2>
      <div class="responsive-table">
          <table>
              <thead>
                  <tr>
                      <th>N</th>
                      <th>NAME</th>
                      <th>MODEL</th>
                      <th>MANUFACTURER</th>
                      <th>COUNTRY</th>
                      <th>QUANTITY</th>
                      <th></th>
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
                      <td>
                        <span class="editButton neo-bg-accent" data-id="{{ $e->id }}">edit</span>
                      </td>
                    </tr>  
                  @endforeach
                  <tr>
                    <td colspan="6">
                      <button class="submit-button neo-bg-accent addRequest">ADD EQUIPMENT REQUEST</button>
                    </td>          
                  </tr>
              </tbody>
          </table>
          <div class="addRequestForm">
            <div class="request-form-controls">
              <h2 class="section-subtitle">ADD REQUEST</h2>
              <form action="{{ route('admin.clientAdminAddRequest') }}" method="post">
                  @csrf
                  <div id="new-request-row" class="neo-input-row">
            
                    <div class="input-cell cell-name">
                        <span class="label-text">NAME...</span>
                        <input type="text" name="name" placeholder="Название товара" class="table-input">
                    </div>
            
                    <div class="input-cell cell-model">
                        <span class="label-text">MODEL</span>
                        <input type="text" name="model" placeholder="Модель" class="table-input">
                    </div>
            
                    <div class="input-cell cell-manufacturer">
                        <span class="label-text">MANUFACTURER</span>
                        <input type="text" name="manufacturer" placeholder="Производитель" class="table-input">
                    </div>
            
                    <div class="input-cell cell-country">
                        <span class="label-text">COUNTRY</span>
                        <input type="text" name="country" placeholder="Страна" class="table-input">
                    </div>
            
                    <div class="input-cell cell-quantity">
                        <span class="label-text">QUANTITY</span>
                        <input type="number" name="quantity" placeholder="Кол-во" min="1" value="1" class="table-input input-number">
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
                      <span class="label-text">N</span>
                      <input disabled type="text" name="code" placeholder="N" class="table-input">
                  </div>
                    <div class="input-cell cell-name">
                        <span class="label-text">NAME</span>
                        <input type="text" name="name" placeholder="Название товара" class="table-input">
                    </div>
            
                    <div class="input-cell cell-model">
                        <span class="label-text">MODEL</span>
                        <input type="text" name="model" placeholder="Модель" class="table-input">
                    </div>
            
                    <div class="input-cell cell-manufacturer">
                        <span class="label-text">MANUFACTURER</span>
                        <input type="text" name="manufacturer" placeholder="Производитель" class="table-input">
                    </div>
            
                    <div class="input-cell cell-country">
                        <span class="label-text">COUNTRY</span>
                        <input type="text" name="country" placeholder="Страна" class="table-input">
                    </div>
            
                    <div class="input-cell cell-quantity">
                        <span class="label-text">QUANTITY</span>
                        <input type="number" name="quantity" placeholder="Кол-во" min="1" value="1" class="table-input input-number">
                    </div>
                  </div>
                
                <button id="add-equipment-btn" class="neo-add-btn neo-bg-accent">
                    + EDIT EQUIPMENT REQUEST
                </button>
              </form>

            </div>
          </div>
      </div>
  </section>

  <hr class="separator"/>

  <section class="support-section">
      <div class="text-area">
          <h3 class="subsection-title">
            <a href="#">Financial Support Tools</a>
          </h3>
          <h3 class="subsection-title">
            <a href="#">Dealers and Service</a>
          </h3>
          <h3 class="subsection-title">
            <a href="{{ route('admin.clientAdminPartners') }}">Partners</a>
          </h3>
      </div>
  </section>


</div>


@endsection