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