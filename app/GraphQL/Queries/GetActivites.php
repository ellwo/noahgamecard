<?php

namespace App\GraphQL\Queries;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

final class GetActivites
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {


            $user=User::find(auth()->user()->id);




            return $user->acivites_groupByDate();



        // TODO implement the resolver
    }
}
