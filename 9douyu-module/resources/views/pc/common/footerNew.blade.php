@if( isset($_SERVER['HTTP_HOST']) && strpos($_SERVER['HTTP_HOST'], 'jiudouyu') === false )
    @include('pc.common.9douyuFooterNew')
@else
    @include('pc.common.jiudouyuFooterNew')
@endif
