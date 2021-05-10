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
 * App\Models\Conversion
 *
 * @property int $id
 * @property int $storage_folder_id
 * @property string $from_type
 * @property string $to_type
 * @property string $status
 * @property string|null $converted_at
 * @property string|null $zipped_at
 * @property string|null $downloaded_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\StorageFolder $folder
 * @method static \Illuminate\Database\Eloquent\Builder|Conversion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Conversion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Conversion query()
 * @method static \Illuminate\Database\Eloquent\Builder|Conversion whereConvertedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conversion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conversion whereDownloadedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conversion whereFromType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conversion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conversion whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conversion whereStorageFolderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conversion whereToType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conversion whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conversion whereZippedAt($value)
 */
	class Conversion extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\File
 *
 * @property int $id
 * @property int $storage_folder_id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $filename
 * @property-read \App\Models\StorageFolder $storageFolder
 * @method static \Illuminate\Database\Eloquent\Builder|File newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|File newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|File query()
 * @method static \Illuminate\Database\Eloquent\Builder|File whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereStorageFolderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereUpdatedAt($value)
 */
	class File extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Product
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 */
	class Product extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\StorageFolder
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $filename
 * @property-read \App\Models\Conversion|null $conversion
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\File[] $files
 * @property-read int|null $files_count
 * @method static \Illuminate\Database\Eloquent\Builder|StorageFolder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StorageFolder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StorageFolder query()
 * @method static \Illuminate\Database\Eloquent\Builder|StorageFolder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StorageFolder whereFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StorageFolder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StorageFolder whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StorageFolder whereUpdatedAt($value)
 */
	class StorageFolder extends \Eloquent {}
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
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property string|null $remember_token
 * @property int|null $current_team_id
 * @property string|null $profile_photo_path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCurrentTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereProfilePhotoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorRecoveryCodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

