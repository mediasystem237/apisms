<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['email', 'nexah_password'];

    public function apiKey()
    {
        return $this->hasOne(ApiKey::class);
    }

    /**
     * Chiffre le mot de passe à l'aide de l'algorithme AES-256-CBC.
     *
     * @param string $password
     * @return string|false Le mot de passe chiffré ou false en cas d'échec
     */
    public static function encryptPassword($password)
    {
        $key = env('APP_ENCRYPTION_KEY');
        $iv = env('APP_ENCRYPTION_IV');

        if (!$key || !$iv) {
            throw new \Exception('Les variables APP_ENCRYPTION_KEY et APP_ENCRYPTION_IV doivent être définies dans le fichier .env');
        }

        // Vérifie la longueur de la clé et de l'IV
        if (strlen($key) !== 32 || strlen($iv) !== 16) {
            throw new \Exception('La clé doit avoir 32 caractères et l\'IV doit en avoir 16 pour AES-256-CBC');
        }

        return openssl_encrypt($password, 'AES-256-CBC', $key, 0, $iv);
    }

    /**
     * Déchiffre le mot de passe à l'aide de l'algorithme AES-256-CBC.
     *
     * @param string $encryptedPassword
     * @return string|false Le mot de passe déchiffré ou false en cas d'échec
     */
    public static function decryptPassword($encryptedPassword)
    {
        $key = env('APP_ENCRYPTION_KEY');
        $iv = env('APP_ENCRYPTION_IV');

        if (!$key || !$iv) {
            throw new \Exception('Les variables APP_ENCRYPTION_KEY et APP_ENCRYPTION_IV doivent être définies dans le fichier .env');
        }

        if (strlen($key) !== 32 || strlen($iv) !== 16) {
            throw new \Exception('La clé doit avoir 32 caractères et l\'IV doit en avoir 16 pour AES-256-CBC');
        }

        return openssl_decrypt($encryptedPassword, 'AES-256-CBC', $key, 0, $iv);
    }
}
