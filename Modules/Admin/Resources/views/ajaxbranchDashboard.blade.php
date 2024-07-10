  <!--case new order-->
  @if (count($recentPlusTwoMinute) != 0 || count($recentMinusOneMinute) != 0 || count($recentMinusTwoMinutes) != 0)
      <h5 class="mt-3 mb-2">طلبات جديدة</h5>
  @endif
  <div class="row">
      @foreach ($recentMinusOneMinute as $key => $value)
          @include('admin::cards.Cardbody')
          @include('admin::cards.CardPopUp')
      @endforeach
  </div>
  <div class="row">
      @foreach ($recentMinusTwoMinutes as $key => $value)
          @include('admin::cards.Cardbody')
          @include('admin::cards.CardPopUp')
      @endforeach
  </div>

  <div class="row">
      @foreach ($recentPlusTwoMinute as $key => $value)
          @include('admin::cards.Cardbody')
          @include('admin::cards.CardPopUp')
      @endforeach
  </div>


  <!----end case new order -->

  <!--case making ready order-->
  @if (count($acceptMinus15Minute) != 0 ||
      count($acceptPlus15Minus20Minute) != 0 ||
      count($acceptPlus20Minute) != 0)
      <h5 class="mt-3 mb-2">طلبات تحت التحضير </h5>
  @endif
  <div class="row">
      @foreach ($acceptMinus15Minute as $key => $value)
          @include('admin::cards.Cardbody')
          @include('admin::cards.CardPopUp')
      @endforeach
  </div>
  <div class="row">
      @foreach ($acceptPlus15Minus20Minute as $key => $value)
          @include('admin::cards.Cardbody')
          @include('admin::cards.CardPopUp')
      @endforeach
  </div>
  <div class="row">
      @foreach ($acceptPlus20Minute as $key => $value)
          @include('admin::cards.Cardbody')
          @include('admin::cards.CardPopUp')
      @endforeach
  </div>
  <!----end  making ready order -->

  <!--case ready for delivery order-->
  @if (count($MainReadyData) != 0)
      <h5 class="mt-3 mb-2">طلبات جاهزة للتسليم </h5>
  @endif
  <div class="row">
      @foreach ($MainReadyData as $key => $value)
          @include('admin::cards.Cardbody')
          @include('admin::cards.CardPopUp')
      @endforeach
  </div>
  <!----end ready for delivery order -->

  <!--case customer in front of  branch order-->
  @if (count($FrontOfBranchMinusOneMinute) != 0 ||
      count($FrontOfBranchMinusTwoMinutes) != 0 ||
      count($FrontOfBranchPlusTwoMinute) != 0)
      <h5 class="mt-3 mb-2">العميل امام الفرع </h5>
  @endif
  <div class="row">
      @foreach ($FrontOfBranchMinusOneMinute as $key => $value)
          @include('admin::cards.Cardbody')
          @include('admin::cards.CardPopUp')
      @endforeach
  </div>
  <div class="row">
      @foreach ($FrontOfBranchMinusTwoMinutes as $key => $value)
          @include('admin::cards.Cardbody')
          @include('admin::cards.CardPopUp')
      @endforeach
  </div>
  <div class="row">
      @foreach ($FrontOfBranchPlusTwoMinute as $key => $value)
          @include('admin::cards.Cardbody')
          @include('admin::cards.CardPopUp')
      @endforeach
  </div>
  <div id="confirm-text"></div>
