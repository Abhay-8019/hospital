{{-- for error message rendering --}}
<div class="col-md-12">
    <div class="errorList">
    </div>
</div>
@include('hsn-code.form_common')
<script>
    // Submit modal form with ajax
    $('#ajaxSaveModal').submit(function(e) {
        e.preventDefault();
        submitModalForm("#ajaxSaveModal");
        return false;
    });
</script>
