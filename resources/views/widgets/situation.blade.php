
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Situation</h3>
    </div>
    
    <ul class="list-group">
        <li class="list-group-item">
            <strong>Compte visible</strong>
            <div class="pull-right visible-account-update {{ $user->visibleAccount() > 0 ? 'text-success' : 'text-danger' }}">{{ $user->visibleAccount()." ".\App\BudgetEntry::CURRENCY }}</div>
        </li>
        <li class="list-group-item">
            <strong>Compte réel</strong>
            <div class="pull-right real-account-update {{ $user->realAccount() > 0 ? 'text-success' : 'text-danger' }}">{{ $user->realAccount()." ".\App\BudgetEntry::CURRENCY }}</div>
        </li>
    </ul>
</div>