<ul class="sidebar-menu">
    <li class="header">{!! string_manip(lang('common.navigation'), 'U') !!}</li>
    @if(isSuperAdmin())
        <li class="treeview">
            <a href="#">
                <i class="fa fa-hospital-o"></i> <span> {!! lang('master.system_admin') !!} </span>
            </a>
            <ul class="treeview-menu">
                <li>
                    <a href="{!! route('hospital.index') !!}">
                        <i class="fa fa-hospital-o"></i> <span> {!! lang('hospital.hospital') !!} </span>
                    </a>

                    <a href="{!! route('role.index') !!}">
                        <i class="fa fa-list-alt"></i> <span> {!! lang('role.role') !!} </span>
                    </a>

                    <a href="{!! route('user.index') !!}">
                        <i class="fa fa-users"></i> <span> {!! lang('user.users') !!} </span>
                    </a>
                </li>
            </ul>
        </li>
    @elseif(isAdmin())
        @include('layouts.sidemenu')
    {{--@elseif(isMember())
        <li class="treeview">
            <a href="{!! route('registration.view-profile', authUserId()) !!}">
                <i class="fa fa-user"></i> <span> {!! lang('master.view_profile') !!} </span>
            </a>
        </li>
        <li class="treeview">
            <a href="{!! route('member.payment-details', authUserId()) !!}">
                <i class="fa fa-list-alt"></i> <span> {!! lang('master.payment_details') !!} </span>
            </a>
        </li>
    @endif--}}
    @elseif(isExecutive())
        <li class="treeview">
            <a href="{!! route('dashboard') !!}">
                <i class="fa fa-dashboard"></i> <span> {!! lang('master.dashboard') !!} </span>
            </a>
        </li>

        <li class="treeview">
            <a href="{!! route('patient.daily-opd-list') !!}">
                <i class="fa fa-stethoscope"></i> <span> {!! lang('opd_master.opd_visits') !!} </span>
            </a>
        </li>

        <li class="treeview">
            <a href="{!! route('patient.ipd-list') !!}">
                <i class="fa fa-bed"></i> <span> {!! lang('ipd_master.ipd_visits') !!} </span>
            </a>
        </li>
    @endif

<!-- @if(isStaff())
        <li class="treeview">
            <a href="{!! route('dashboard') !!}">
                <i class="fa fa-dashboard"></i> <span> {!! lang('master.dashboard') !!} </span>
            </a>
        </li>

        <li class="treeview">
            <a href="{!! route('patient.opd-procedure-list') !!}">
                <i class="fa fa-cubes"></i> <span> {!! lang('opd_master.patient_procedures') !!} </span>
            </a>
        </li>
    @endif

    @if(isStore())
        <li class="treeview">
            <a href="{!! route('dashboard') !!}">
                <i class="fa fa-dashboard"></i> <span> {!! lang('master.dashboard') !!} </span>
            </a>
        </li>

        <li class="treeview">
            <a href="{!! route('patient-test.index') !!}">
                <i class="fa fa-flask"></i> <span> {!! lang('patient_test.patient_tests') !!} </span>
            </a>
        </li>

        <li class="treeview">
            <a href="javascript:void(0)">
                <i class="fa fa-pie-chart"></i> <span> {!! lang('reports.reports') !!} </span>
            </a>
            <ul class="treeview-menu">
                <li>
                    <a href="{!! route('report.patient-tests') !!}">
                        <i class="fa fa-circle-o"></i>
                        {!! lang('patient_test.patient_tests') !!}
                    </a>
                </li>
            </ul>
        </li>
    @endif
</ul>                -->