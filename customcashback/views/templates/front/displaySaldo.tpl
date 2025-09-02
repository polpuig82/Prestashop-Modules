{if $customer.is_logged && is_array($CashBack) && not isset($CashBack.error)}
    &nbsp;|&nbsp;Saldo Disfrutista: {$CashBack.balance}€
{/if}
