<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Utilisation carte <small>(7 derniers jours)</small></h3>
    </div>
    
    <ul class="list-group">
        <li class="list-group-item">
            <strong>Retraits</strong>
            <div class="pull-right">{{ $user->sumWithdrawInPreviousPeriod(7)." ".\App\BudgetEntry::CURRENCY }}</div>
        </li>
        <li class="list-group-item">
            <strong>Paiements carte</strong>
            <div class="pull-right">{{ $user->sumCardInPreviousPeriod(7)." ".\App\BudgetEntry::CURRENCY }}</div>
        </li>
    </ul>
</div>