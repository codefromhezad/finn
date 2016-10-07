@extends('layouts.app')

@section('content')
<div class="container dashboard">
    <div class="row">
        <div class="col-md-9">
            <form action="{{ url('add_entry') }}" method="post">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Transactions</h3>

                        <nav class="pagination-nav">
                            {{ $entries->links() }}
                        </nav>
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
                            
                            <!-- Lines of data -->
                            @foreach($entries as $entry)
                                {!! view('partials._entries_table_line', ['entry' => $entry]) !!}
                            @endforeach
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

            <div class="widget-tools">
                {!! \App\Widget::tools(\Auth::user()) !!}
            </div>
        </div>
    </div>
</div>
@endsection
