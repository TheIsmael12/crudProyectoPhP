<?php

class Validator
{
    private $accesoDatos;  // Usar la instancia de AccesoDatos

    // El constructor ahora acepta una instancia de AccesoDatos
    public function __construct(AccesoDatos $accesoDatos)
    {
        $this->accesoDatos = $accesoDatos;
    }

    // Validar email
    public function isValidEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    // Validar IP
    public function isValidIP(string $ip): bool
    {
        return filter_var($ip, FILTER_VALIDATE_IP) !== false;
    }

    // Validar formato (999-999-9999)
    public function isValidPhone(string $phone): bool
    {
        return preg_match('/^\d{3}-\d{3}-\d{4}$/', $phone) === 1;
    }

    // Validar que no se repite el email
    public function isEmailUnique(string $email, int $id = null): bool
    {
        // Llamada a la función validarEmail en AccesoDatos
        $count = $this->accesoDatos->validarEmail($email, $id);

        // Retornar true si no hay coincidencias, false si las hay
        return $count == 0;
    }

    // Validar todos los campos de un cliente
    public function validateClient(array $client): array
    {
        $errors = [];

        // Validación de email
        if (empty($client['email']) || !$this->isValidEmail($client['email'])) {
            $errors['email'] = 'El email no es válido o está vacío.';
        } elseif (!$this->isEmailUnique($client['email'], $client['id'] ?? null)) {
            $errors['email'] = 'El email ya está en uso.';
        }

        // Validación de IP
        if (empty($client['ip']) || !$this->isValidIP($client['ip'])) {
            $errors['ip'] = 'La dirección IP no es válida o está vacía.';
        }

        // Validación de teléfono
        if (empty($client['phone']) || !$this->isValidPhone($client['phone'])) {
            $errors['phone'] = 'El número de teléfono no tiene el formato correcto (999-999-9999) o está vacío.';
        }

        return $errors;
    }
}
