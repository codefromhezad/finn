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
                                <th>Channel</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Lines of data -->
                            @foreach($entries as $entry)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="check-entry" data-entry-id="{{$entry->id}}" {{ $entry->checked ? "checked" : "" }}>
                                    </td>
                                    <td>{{ $entry->date }}</td>
                                    <td>{{ $entry->label }}</td>
                                    <td class="text-danger">{{ $entry->debitAmount() }}</td>
                                    <td class="text-success">{{ $entry->creditAmount() }}</td>
                                    <td>{{ $entry->channel->label }}</td>
                                    <td style="text-align: center;"><a href="#" class="delete-entry" data-entry-id="{{$entry->id}}">&#x2715;</a></td>
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
                </div>
            </form>
        </div>

        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Sitation</h3>
                </div>
                
                <ul class="list-group">
                    <li class="list-group-item">
                        <strong>Compte visible</strong>
                        <div class="pull-right visible-account-update {{ \App\BudgetEntry::visibleAccount() > 0 ? 'text-success' : 'text-danger' }}">{{ \App\BudgetEntry::visibleAccount()." ".\App\BudgetEntry::CURRENCY }}</div>
                    </li>
                    <li class="list-group-item">
                        <strong>Compte réel</strong>
                        <div class="pull-right real-account-update {{ \App\BudgetEntry::realAccount() > 0 ? 'text-success' : 'text-danger' }}">{{ \App\BudgetEntry::realAccount()." ".\App\BudgetEntry::CURRENCY }}</div>
                    </li>
                </ul>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Utilisation carte <small>(7 derniers jours)</small></h3>
                </div>
                
                <ul class="list-group">
                    <li class="list-group-item">
                        <strong>Retraits</strong>
                        <div class="pull-right">Blabla blablabla</div>
                    </li>
                    <li class="list-group-item">
                        <strong>Paiements carte</strong>
                        <div class="pull-right">Blabla blablabla</div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
