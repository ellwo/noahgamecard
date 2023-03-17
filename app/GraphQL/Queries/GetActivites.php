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





            $activites= $user->acivites_groupByDate($args["page"]??1);
            return [
                'activites'=>$activites['activites'],
                'paginatorInfo'=>$activites['paginatorInfo']
            ];





        // TODO implement the resolver
    }
}
