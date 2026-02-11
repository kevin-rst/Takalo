<?php

namespace app\services;

use app\repositories\UsersRepository;

class Validator
{
    public static function containsUpper(string $str): bool
    {
        return preg_match('/[A-Z]/', $str) === 1;
    }

    public static function containsLower(string $str): bool
    {
        return preg_match('/[a-z]/', $str) === 1;
    }

    public static function containsNum(string $str): bool
    {
        return preg_match('/[0-9]/', $str) === 1;
    }

    public static function containsSpecChar(string $str): bool
    {
        return preg_match('/[^a-zA-Z0-9]/', $str) === 1;
    }

    public static function validateRegister(array $input, UsersRepository $repo = null)
    {
        $errors = [
            'nom' => '',
            'email' => '',
            'password' => '',
            'confirm_password' => '',
        ];

        $values = [
            'nom' => trim((string)($input['nom'] ?? '')),
            'email' => trim((string)($input['email'] ?? '')),
        ];

        $password = (string)($input['password'] ?? '');
        $confirm  = (string)($input['confirm_password'] ?? '');

        if (mb_strlen($values['nom']) < 2) $errors['nom'] = "Le nom doit contenir au moins 2 caractères.";

        if ($values['email'] === '') $errors['email'] = "L'email est obligatoire.";
        elseif (!filter_var($values['email'], FILTER_VALIDATE_EMAIL))
            $errors['email'] = "L'email n'est pas valide (ex: nom@domaine.com).";

        if (strlen($password) < 8)
            $errors['password'] = "Le mot de passe doit contenir au moins 8 caractères.";
        elseif (!self::containsUpper($password))
            $errors['password'] = "Le mot de passe doit contenir au moins une lettre majuscule.";
        elseif (!self::containsLower($password))
            $errors['password'] = "Le mot de passe doit contenir au moins une lettre minuscule.";
        elseif (!self::containsNum($password))
            $errors['password'] = "Le mot de passe doit contenir au moins un chiffre.";
        elseif (!self::containsSpecChar($password))
            $errors['password'] = "Le mot de passe doit contenir au moins un caractère spécial.";

        if (strlen($confirm) < 8)
            $errors['confirm_password'] = "Veuillez confirmer le mot de passe (min 8 caractères).";
        elseif (!self::containsUpper($confirm))
            $errors['confirm_password'] = "La confirmation du mot de passe doit contenir au moins une lettre majuscule.";
        elseif (!self::containsLower($confirm))
            $errors['confirm_password'] = "La confirmation du mot de passe doit contenir au moins une lettre minuscule.";
        elseif (!self::containsNum($confirm))
            $errors['confirm_password'] = "La confirmation du mot de passe doit contenir au moins un chiffre.";
        elseif (!self::containsSpecChar($confirm))
            $errors['confirm_password'] = "La confirmation du mot de passe doit contenir au moins un caractère spécial.";
        elseif ($password !== $confirm) {
            $errors['confirm_password'] = "Les mots de passe ne correspondent pas.";
            if ($errors['password'] === '')
                $errors['password'] = "Vérifiez le mot de passe et sa confirmation.";
        }

        if ($repo && $errors['email'] === '' && $repo->emailExists($values['email'])) {
            $errors['email'] = "Cet email est déjà utilisé.";
        }

        $ok = true;
        foreach ($errors as $m) {
            if ($m !== '') {
                $ok = false;
                break;
            }
        }

        return ['ok' => $ok, 'errors' => $errors, 'values' => $values];
    }

    public static function validateLogin(array $input, UsersRepository $repo = null)
    {


        $errors = [
            'nom' => '',
            'password' => '',
            'confirm_password' => ''
        ];

        $values = [
            'nom' => trim((string) ($input['nom'] ?? ''))
        ];

        $password = (string) ($input['password'] ?? '');
        $confirm = (string) ($input['confirm_password'] ?? '');

        if (mb_strlen($values['nom']) < 2)
            $errors['nom'] = "Le nom doit contenir au moins 2 caractères.";

        if (strlen($password) < 8)
            $errors['password'] = "Le mot de passe doit contenir au moins 8 caractères.";
        elseif (!self::containsUpper($password))
            $errors['password'] = "Le mot de passe doit contenir au moins une lettre majuscule.";
        elseif (!self::containsLower($password))
            $errors['password'] = "Le mot de passe doit contenir au moins une lettre minuscule.";
        elseif (!self::containsNum($password))
            $errors['password'] = "Le mot de passe doit contenir au moins un chiffre.";
        elseif (!self::containsSpecChar($password))
            $errors['password'] = "Le mot de passe doit contenir au moins un caractère spécial.";

        if (strlen($confirm) < 8)
            $errors['confirm_password'] = "Veuillez confirmer le mot de passe (min 8 caractères).";
        elseif (!self::containsUpper($confirm))
            $errors['confirm_password'] = "La confirmation du mot de passe doit contenir au moins une lettre majuscule.";
        elseif (!self::containsLower($confirm))
            $errors['confirm_password'] = "La confirmation du mot de passe doit contenir au moins une lettre minuscule.";
        elseif (!self::containsNum($confirm))
            $errors['confirm_password'] = "La confirmation du mot de passe doit contenir au moins un chiffre.";
        elseif (!self::containsSpecChar($confirm))
            $errors['confirm_password'] = "La confirmation du mot de passe doit contenir au moins un caractère spécial.";
        elseif ($password !== $confirm) {
            $errors['confirm_password'] = "Les mots de passe ne correspondent pas.";
            if ($errors['password'] === '')
                $errors['password'] = "Vérifiez le mot de passe et sa confirmation.";
        }

        // verify identity
        if ($repo && $errors['password'] === '' && $errors['confirm_password'] === '') {
            $result = $repo->getUser($values['nom']);

            if ($result) {
                if (!password_verify($password, $result['password_hash'])) {
                    $errors['password'] = "Vérifiez le mot de passe.";
                    $errors['confirm_password'] = "Vérifiez la confirmation du mot de passe.";
                }
            } else {
                $errors['nom'] = "Vérifiez le nom.";
            }
        }

        $ok = true;
        foreach ($errors as $m) {
            if ($m !== '') {
                $ok = false;
                break;
            }
        }

        return ['ok' => $ok, 'errors' => $errors, 'values' => $values];
    }
}
