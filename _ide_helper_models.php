<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models\Auth{
/**
 * App\Models\Auth\User
 *
 * @property int $id
 * @property string $username
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
 */
	class User extends \Eloquent implements \Illuminate\Contracts\Auth\MustVerifyEmail {}
}

namespace App\Models\ToDo{
/**
 * App\Models\ToDo\ToDoList
 *
 * @property int $id
 * @property string $title
 * @property int|null $undone
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ToDoList newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ToDoList newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ToDoList query()
 * @method static \Illuminate\Database\Eloquent\Builder|ToDoList whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ToDoList whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ToDoList whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ToDoList whereUndone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ToDoList whereUpdatedAt($value)
 */
	class ToDoList extends \Eloquent {}
}

namespace App\Models\ToDo{
/**
 * App\Models\ToDo\ToDoPlan
 *
 * @property int $id
 * @property int $list_id
 * @property string $title
 * @property string|null $description
 * @property int $priority
 * @property bool $complete
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ToDoPlan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ToDoPlan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ToDoPlan query()
 * @method static \Illuminate\Database\Eloquent\Builder|ToDoPlan whereComplete($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ToDoPlan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ToDoPlan whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ToDoPlan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ToDoPlan whereListId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ToDoPlan wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ToDoPlan whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ToDoPlan whereUpdatedAt($value)
 */
	class ToDoPlan extends \Eloquent {}
}

