@extends('user.layouts.app')

@section('title', 'DOCKU | Корзина')

@section('content')
  <div class="container-fluid cart-page">
    <div class="row justify-content-center px-2">
      <div class="col-12">
        <p class="font-weight-bolder h4" style="color: #2D3134;">Корзина</p>
      </div>
      <div class="col-md-8">
        <transition name="slide-fade" mode="out-in" appear>
          <div class="row" key="products" v-if="!cartLoader">
            <div class="col-12">

              <div class="row mt-3 mx-0" v-for="product in $store.getters.productsCart" style="border-color: #4F545B !important; border-radius: 16px;">
                @include('user.cart.item-page')
              </div>

            </div>
          </div>

          <div class="row justify-content-center mt-5" key="loader" v-else>
            <div class="col-auto">
              <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
            </div>
          </div>
        </transition>
      </div>

      <div class="col-md-4 mt-md-0 mt-4">
        <div class="row">
          <div class="col-12 justify-content-end d-flex mb-1" v-if="!$store.state.auth">
            <a href="{{ route('login') }}" class="text-decoration-none" style="font-size: .9em;">Войдите в аккаунт, чтобы оплачивать быстрее</a>
          </div>
          <div class="col-12">
            <div class="row result-wrapper">
              <div class="col-12">
                <a href="{{ route('order.create') }}" class="create-order-button" :class="$store.state.cart.items.length < 1 ? 'disabled' : null">Перейти к оплате</a>
              </div>
              <div class="col-12 d-flex justify-content-between">
                <span>Сумма:</span>
                <span>40 000 ₸</span>
              </div>
              <div class="col-12 d-flex justify-content-between">
                <span>Скидка:</span>
                <span>40 000 ₸</span>
              </div>
              <div class="col-12 d-flex justify-content-between result-field">
                <span class="title">Итого:</span>
                <span class="value">30 000 ₸</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection


@section('js')
@endsection

