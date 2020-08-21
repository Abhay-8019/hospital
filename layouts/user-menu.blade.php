@foreach($menu as $key => $data)    
    <li>
        <a href="{{($data['route'] !='') ? route($data['route']) : '#' }}"><i class="fa fa-folder"></i>&nbsp; {!! $data['name'] !!} <span class="fa arrow"></span> </a>
        <ul class="nav nav-second-level"> 
        @foreach($data['child'] as $childData)               
            <li>
                <a href="{{($childData['route'] !='') ? route($childData['route']) : '#' }}"><i class="fa fa-cubes"></i>&nbsp; {!! $childData['name'] !!} <span class="fa arrow"></span> </a>
                <ul class="nav nav-second-level">  
                @foreach($childData['child'] as $subChild)
                @if($subChild['is_in_menu'] != '')                         
                    <li>
                        <a href="{{($subChild['route'] !='') ? route($subChild['route']) : '#' }}">{!! $subChild['name'] !!} </a>
                    </li>
                @endif
                @endforeach
                </ul>
            </li>
        @endforeach
        </ul>
    </li>
@endforeach