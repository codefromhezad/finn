@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-9">
            <form action="{{ url('add_entry') }}" method="post">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Budget</h3>
                    </div>

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <table class="table table-condensed dashboard-budget-table">
                        <thead>
                            <tr>
                                <th>&#x2713;</th>
                                <th>Date</th>
                                <th>Label</th>
                                <th>Débit</th>
                                <th>Crédit</th>
                                <th>Moyen P<sup>ment</sup></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Lines of data -->
                            @foreach($entries as $entry)
                                <tr class="read-line" data-line-id="{{$entry->id}}">
                                    <td>
                                        <input type="checkbox" class="check-entry" data-entry-id="{{$entry->id}}" {{ $entry->checked ? "checked" : "" }}>
                                    </td>
                                    <td>{{ $entry->date }}</td>
                                    <td>{{ $entry->label }}</td>
                                    <td class="text-danger">{{ $entry->debitAmount() }}</td>
                                    <td class="text-success">{{ $entry->creditAmount() }}</td>
                                    <td>{{ $entry->channel->label }}</td>
                                    <td class="actions-td">
                                        <a href="#" class="edit-entry" data-entry-id="{{$entry->id}}">&#x270E;</a>
                                        <a href="#" class="delete-entry" data-entry-id="{{$entry->id}}">&#x2715;</a>
                                    </td>
                                </tr>

                                <tr class="edit-line-template" data-line-id="{{$entry->id}}">
                                    <td>
                                        <label style="margin-top: 4px;">
                                            <input type="checkbox" name="edit-checked" id="edit-checked" value="1" {{ $entry->checked ? "checked" : "" }}>
                                        </label>
                                    </td>
                                    <td>
                                        <input style="width: 100px;" class="form-control input-sm" type="text" name="edit-date" id="edit-date" value="{{ $entry->date }}">
                                    </td>
                                    <td>
                                        <input class="form-control input-sm" type="text" name="edit-label" id="edit-label" value="{{ $entry->label }}">
                                    </td>
                                    <td>
                                        <div class="input-group" style="width: 140px;">
                                            <input class="form-control input-sm" type="text" name="edit-amount-debit" id="edit-amount-debit" value="{{ $entry->amount < 0 ? number_format(abs($entry->amount), 2)." ".\App\BudgetEntry::CURRENCY : "" }}">
                                            <div class="input-group-addon">{{ \App\BudgetEntry::CURRENCY }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group" style="width: 140px;">
                                            <input class="form-control input-sm" type="text" name="edit-amount-credit" id="edit-amount-credit" value="{{ $entry->amount > 0 ? number_format(abs($entry->amount), 2)." ".\App\BudgetEntry::CURRENCY : "" }}">
                                            <div class="input-group-addon">{{ \App\BudgetEntry::CURRENCY }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        <select class="form-control input-sm" name="edit-channel_id" id="edit-channel_id">
                                            @foreach(\App\BudgetChannel::all() as $channel)
                                                <option value="{{ $channel->id }}" {{ $channel->id == $entry->channel_id ? "selected" : "" }}>{{ $channel->label }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="edit-actions">
                                        <button class="btn btn-primary btn-xs save" data-entry-id="{{ $entry->id }}" type="submit">Ok</button>
                                        <a class="btn btn-default btn-xs cancel">Annuler</a>
                                    </td>
                                </tr>
                            @endforeach

                            <!-- New entry form -->
                            @if (count($errors) > 0)
                                <tr>
                                    <td colspan="7">
                                        <div class="alert alert-danger" style="margin-bottom: 0;">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endif

                            <tr class="new-line">
                                <td>
                                    <label style="margin-top: 4px;">
                                        <input type="checkbox" name="checked" id="new-checked" value="1">
                                    </label>
                                </td>
                                <td>
                                    <input style="width: 100px;" class="form-control input-sm" type="text" name="date" id="new-date">
                                </td>
                                <td>
                                    <input class="form-control input-sm" type="text" name="label" id="new-label">
                                </td>
                                <td>
                                    <div class="input-group" style="width: 140px;">
                                        <input class="form-control input-sm" type="text" name="amount-debit" id="new-amount-debit">
                                        <div class="input-group-addon">{{ \App\BudgetEntry::CURRENCY }}</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group" style="width: 140px;">
                                        <input class="form-control input-sm" type="text" name="amount-credit" id="new-amount-credit">
                                        <div class="input-group-addon">{{ \App\BudgetEntry::CURRENCY }}</div>
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
                </div>
            </form>
        </div>

        <div class="col-md-3">
            <div class="widget-situation">
                {!! \App\Widget::situation(\Auth::user()) !!}
            </div>

            <div class="widget-carte">
                {!! \App\Widget::carte(\Auth::user()) !!}
            </div>
        </div>
    </div>
</div>
@endsection
