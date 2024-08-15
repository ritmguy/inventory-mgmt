@if((Session::get('results')))

<div class="modal fade" id="resultsModal" tabindex="-1" role="dialog" aria-labelledby="resultsModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resultsModalLabel">Modal title</h5>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script>
    $(function() {
        let $resultSet = "{{ $results }}";

        $('#resultsModal.modal-body').text($resultSet.exception);

        $('#resultsModal').modal('show');
    });
</script>
@endif