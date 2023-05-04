<?php

namespace App\GraphQL\Queries;

use App\Models\User;

final class GetUserNotificationsPG
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver


        $page=isset($args["page"])?$args['page']:'1';
        \request()->request->set("page",$page);

        $user=User::find(auth()->user()->id);
        if($user!=null){

            $data=$user->user_notifications()->orderBy('created_at','desc')
            ->paginate(2);

            return [
                'data'=>$data,
                'paginatorInfo'=>[
                    'total'=>$data->total(),
                    'hasMorePages'=>$data->hasMorePages()
                ]
              ];
        }
    }
}
