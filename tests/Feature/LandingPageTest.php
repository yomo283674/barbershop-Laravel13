<?php

namespace Tests\Feature;

use Tests\TestCase;

class LandingPageTest extends TestCase
{
    /**
     * Verifica que la página de inicio o sitio web cargue exitosamente.
     */
    public function test_landing_page_carga_correctamente(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
