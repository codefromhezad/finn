@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">Budget</div>

                <form action="{{ url('add_entry') }}" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <table class="table table-condensed">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>&#x2713;</th>
                                <th>Label</th>
                                <th>Débit</th>
                                <th>Crédit</th>
                                <th>Channel</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Lines of data -->
                            @foreach($entries as $entry)
                                <tr>
                                    <td>{{ $entry->date }}</td>
                                    <td>
                                        <input type="checkbox" data-entry-id="{{$entry->id}}" {{ $entry->checked ? "checked" : "" }}>
                                    </td>
                                    <td>{{ $entry->label }}</td>
                                    <td class="text-danger">{{ $entry->debitAmount() }}</td>
                                    <td class="text-success">{{ $entry->creditAmount() }}</td>
                                    <td>{{ $entry->channel->label }}</td>
                                    <td></td>
                                </tr>
                            @endforeach
                            <!-- New entry form -->
                            <tr class="new-line">
                                <td>
                                    <input style="width: 100px;" class="form-control input-sm" type="text" name="date" id="new-date">
                                </td>
                                <td>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="checked" id="new-checked">
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <input class="form-control input-sm" type="text" name="label" id="new-label">
                                </td>
                                <td>
                                    <div class="input-group" style="width: 140px;">
                                        <input class="form-control input-sm" type="text" name="amount-debit" id="new-amount-debit">
                                        <div class="input-group-addon">€</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group" style="width: 140px;">
                                        <input class="form-control input-sm" type="text" name="amount-credit" id="new-amount-credit">
                                        <div class="input-group-addon">€</div>
                                    </div>
                                </td>
                                <td>
                                    <select class="form-control input-sm" name="channel_id" id="new-channel_id">
                                        @foreach(\App\BudgetChannel::all() as $channel)
                                            <option value="{{ $channel->id }}" {{ $channel->slug == "carte-credit" ? "selected" : "" }}>{{ $channel->label }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <button class="btn btn-primary btn-sm" type="submit">Ajouter</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>

                <div class="panel-footer">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
