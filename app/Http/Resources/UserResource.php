<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    protected $token;

    public function __construct($resource, $token)
    {
        parent::__construct($resource);
        $this->token = $token;
    }
    public function toArray($request)
    {
        return [
           'user' => [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
           
           ],
           'token' => $this->token
           
        ];
    }
}
