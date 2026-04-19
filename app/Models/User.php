<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

#[Fillable([
    'full_name',
    'username',
    'email',
    'password',
    'birth_day',
    'gender',
    'role_id',
    'avatar_image',
    'avatar_url',
    'status',
])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    protected $primaryKey = 'user_id';

    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => 'integer',
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getAvatarImageUrlAttribute(): string
    {
        $avatarImage = (string) ($this->avatar_image ?? $this->avatar_url ?? '');

        if ($avatarImage === '') {
            return '';
        }

        if (str_starts_with($avatarImage, 'http://') || str_starts_with($avatarImage, 'https://')) {
            return $avatarImage;
        }

        $normalizedAvatar = ltrim($avatarImage, '/');

        if (str_starts_with($normalizedAvatar, 'storage/')) {
            return asset($normalizedAvatar);
        }

        if (Storage::disk('public')->exists($normalizedAvatar)) {
            return asset('storage/' . $normalizedAvatar);
        }

        if (file_exists(public_path($normalizedAvatar))) {
            return asset($normalizedAvatar);
        }

        return asset('images/' . basename($normalizedAvatar));
    }
   public function sendPasswordResetNotification($token)
    {
        $this->notify(new class($token) extends \Illuminate\Auth\Notifications\ResetPassword {
            public function toMail($notifiable)
            {
                // Tạo cái link chứa token
                $url = url(route('password.reset', [
                    'token' => $this->token,
                    'email' => $notifiable->getEmailForPasswordReset(),
                ], false));

                // Gửi bằng giao diện custom
                return (new \Illuminate\Notifications\Messages\MailMessage)
                    ->subject('Thông báo khôi phục mật khẩu - MusicApp')
                    ->view('auth.reset-email', ['url' => $url]);
            }
        });
    }
}