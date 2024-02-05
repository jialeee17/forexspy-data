<?php

namespace App\Repositories;

use App\Models\Account;

class AccountRepository
{
    public function getAllAccounts()
    {
        return Account::all();
    }

    public function createAccount(array $data)
    {
        return Account::create($data);
    }

    public function updateAccount($id, array $data)
    {
        $account = Account::findOrFail($id);
        $account->update($data);

        return $account;
    }

    public function deleteAccount($id)
    {
        $account = Account::findOrFail($id);

        return $account->delete();
    }
}
