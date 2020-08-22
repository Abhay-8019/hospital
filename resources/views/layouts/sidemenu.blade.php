<li class="treeview">
    <a href="{!! route('dashboard') !!}">
        <i class="fa fa-dashboard"></i> <span> {!! lang('master.dashboard') !!} </span>
    </a>
</li>
<li class="treeview">
    <a href="javascript:void(0)">
        <i class="fa fa-book"></i>
        <span class="title"> Masters </span>
    </a>
    <ul class="treeview-menu">
        <li>
            <a href="{!! route('financial-year.index') !!}">
                <span class="title"> {!! lang('financial_year.financial_years') !!} </span>
            </a>
        </li>
        <li>
            <a href="{!! route('tax.index') !!}">
                <span class="title"> {!! lang('tax.tax') !!} </span>
            </a>
        </li>

        <li>
            <a href="{!! route('hsn-code.index') !!}">
                <span class="title"> {!! lang('hsn_code.hsn_code') !!} </span>
            </a>
        </li>

        <li>
            <a href="{!! route('unit.index') !!}">
                <span class="title"> {!! lang('unit.unit') !!} </span>
            </a>
        </li>

        <li>
            <a href="{!! route('product-group.index') !!}">
                <span class="title"> {!! lang('product_group.product_groups') !!} </span>
            </a>
        </li>

        <li>
            <a href="{!! route('products.index') !!}">
                <span class="title"> {!! lang('products.products') !!} </span>
            </a>
        </li>
        <li>
            <a href="{!! route('role.index') !!}">
                <span class="title"> {!! lang('role.role') !!} </span>
            </a>
        </li>
        <li>
            <a href="{!! route('user.index') !!}">
                <span class="title"> {!! lang('user.users') !!} </span>
            </a>
        </li>
    </ul>
</li>

  

<li class="treeview hide">
    <a href="{!! route('employee-type.index') !!}">
        <i class="fa fa-building-o"></i> <span> {!! lang('employee_type.employee_type') !!} </span>
    </a>
</li>

<li class="treeview hide">
    <a href="{!! route('staff.index') !!}">
        <i class="fa fa-building-o"></i> <span> {!! lang('staff.staff') !!} </span>
    </a>
</li>