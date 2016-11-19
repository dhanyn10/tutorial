@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $title or 'Send Message' }}</div>
                <div class="panel-body">

                    @if (session()->has('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    @if (session()->has('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <th>Number</th>
                                <th>Name</th>
                                <th>Message</th>
                                <th>Type</th>
                                <th>Created</th>
                                <th>Expired</th>
                                <th>Actions</th>
                            </thead>
                            <tbody>
                                @foreach($messages as $message)
                                    <tr>
                                        <td>{{ $message->contact_name }}</td>
                                        <td>{{ $message->contact_number }}</td>
                                        <td>{{ $message->message }}</td>
                                        <td><span class="label label-{{ $types[$message->type] }}">{{ $message->type }}</span></td>
                                        <td>{{ $message->created_at->format('d-m-Y H:i') }}</td>
                                        <td>{{ $message->expired_at->format('d-m-Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('message.delete', [$message->id]) }}" class="btn btn-danger btn-sm delete">
                                                Delete
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if ($messages->total() <= 0)
                        <div class="alert alert-info">There is no message at this time.</div>
                    @endif

                    {{ $messages->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="modal-delete">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Delete Confirmation</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure wanto to delete this message?</p>
            </div>

            <form method="POST" id="form-delete">
                {{ csrf_field() }}
                {{ method_field('delete') }}

                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">
                        Delete
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    $(function(){
        $('a.delete').click(function(){
            $('#modal-delete').modal('show');

            $('#form-delete').attr('action', $(this).attr('href'));

            return false;
        });
    })
</script>
@endpush
