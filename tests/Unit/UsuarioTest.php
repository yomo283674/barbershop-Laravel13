<?php

namespace Tests\Unit;

use App\Models\Usuario;
use Tests\TestCase;

class UsuarioTest extends TestCase
{
    public function test_identifica_correctamente_rol_administrador(): void
    {
        $usuario = new Usuario;
        $usuario->id_rol = Usuario::ROL_ADMIN;

        $this->assertTrue($usuario->esAdmin());
        $this->assertFalse($usuario->esBarbero());
        $this->assertFalse($usuario->esCliente());
    }

    public function test_identifica_correctamente_rol_barbero(): void
    {
        $usuario = new Usuario;
        $usuario->id_rol = Usuario::ROL_BARBERO;

        $this->assertFalse($usuario->esAdmin());
        $this->assertTrue($usuario->esBarbero());
        $this->assertFalse($usuario->esCliente());
    }

    public function test_identifica_correctamente_rol_cliente(): void
    {
        $usuario = new Usuario;
        $usuario->id_rol = Usuario::ROL_CLIENTE;

        $this->assertFalse($usuario->esAdmin());
        $this->assertFalse($usuario->esBarbero());
        $this->assertTrue($usuario->esCliente());
    }

    public function test_password_esta_oculto_en_la_serializacion(): void
    {
        $usuario = new Usuario([
            'nombre' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'secret123',
        ]);

        $array = $usuario->toArray();

        $this->assertArrayNotHasKey('password', $array);
    }
}
