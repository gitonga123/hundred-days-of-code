<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Setting
 *
 * @property int $id
 * @property string $current_time
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting query()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereCurrentTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereUpdatedAt($value)
 */
	class Setting extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SfDates
 *
 * @property int $id
 * @property string $event_date
 * @property int $processed
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $number_of_records
 * @method static \Illuminate\Database\Eloquent\Builder|SfDates newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SfDates newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SfDates query()
 * @method static \Illuminate\Database\Eloquent\Builder|SfDates whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SfDates whereEventDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SfDates whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SfDates whereNumberOfRecords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SfDates whereProcessed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SfDates whereUpdatedAt($value)
 */
	class SfDates extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Sofascore
 *
 * @property int $id
 * @property string $competition
 * @property string $player_1
 * @property string $player_2
 * @property string|null $home_odd
 * @property string|null $away_odd
 * @property string|null $home_change
 * @property string|null $away_change
 * @property string|null $expected_value_home
 * @property string|null $actual_value_home
 * @property string|null $expected_value_away
 * @property string|null $actual_value_away
 * @property string $result
 * @property string $home_score
 * @property string $away_score
 * @property string $match_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $event_date
 * @property string|null $correct_score
 * @property int $updated_score
 * @property string $home_total
 * @property string $away_total
 * @property string $both_total
 * @method static \Illuminate\Database\Eloquent\Builder|Sofascore newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sofascore newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sofascore query()
 * @method static \Illuminate\Database\Eloquent\Builder|Sofascore updatedScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sofascore whereActualValueAway($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sofascore whereActualValueHome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sofascore whereAwayChange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sofascore whereAwayOdd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sofascore whereAwayScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sofascore whereAwayTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sofascore whereBothTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sofascore whereCompetition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sofascore whereCorrectScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sofascore whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sofascore whereEventDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sofascore whereExpectedValueAway($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sofascore whereExpectedValueHome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sofascore whereHomeChange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sofascore whereHomeOdd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sofascore whereHomeScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sofascore whereHomeTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sofascore whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sofascore whereMatchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sofascore wherePlayer1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sofascore wherePlayer2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sofascore whereResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sofascore whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sofascore whereUpdatedScore($value)
 */
	class Sofascore extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

