<?php
    $renderMenu = renderMenu();
?>
@foreach($renderMenu as $key => $menu)
    <li class="treeview @if(isset($menu['child'])) has-sub-menu @endif" data-id="{!! $menu['id'] !!}" data-orderId="{!! $menu['_order'] !!}" >

    <a href="{!! (empty($menu['route']))? 'javascript:void(0);' : route($menu['route']) !!}">
        <i class="{!! $menu['icon'] !!}"></i>&nbsp;
        <span>{!! $menu['name'] !!}</span>
        @if(isset($menu['child']))
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        @endif
    </a>
    @if(isset($menu['child']))
        <ul class="treeview-menu">
            @foreach($menu['child'] as $childMenu)
                <li>
                    <?php
                        $route = null;
                        if($childMenu['id'] == 47 && $childMenu['route'] == 'reports.member-report') {
                            $routes = route($childMenu['route'], 1);
                        }else if ($childMenu['id'] == 48 && $childMenu['route'] == 'reports.member-report') {
                            $routes = route($childMenu['route'], 2);
                        }else {
                            $routes = route($childMenu['route']);
                        }
                    ?>
                    <a href="{!! (!empty($childMenu['route'])) ? $routes : 'javascript:void(0);' !!}">
                        <i class="{!! (isset($childMenu['icon']))? $childMenu['icon'] : '' !!}"></i>&nbsp;
                        <span>{!! $childMenu['name'] !!}</span>
                        @if(isset($childMenu['child']))
                            <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        @endif
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
</li>
@endforeach
