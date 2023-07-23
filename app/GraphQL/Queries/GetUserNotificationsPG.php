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



            $unread=$user->user_notifications()->where('state','=',0)->count();
            if($unread<15)
            $unread=15;

            $data=$user->user_notifications()->orderBy('created_at','desc')
            ->paginate($unread);

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
