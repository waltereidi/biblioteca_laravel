<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\ZapierIntegration;

class ZapierControllerTest extends TestCase
{
    use RefreshDatabase;

    private string $bearerToken;

    protected function setUp(): void
    {
        parent::setUp();

        // Simula o token do .env (ou valor fixo de teste)
        $this->bearerToken = env('API_BEARER_TOKEN', default: 'token_teste_padrao');
    }
    /** @test */
    public function deve_registrar_integracao_e_salvar_arquivo_no_storage()
    {
        // Simula o disco 'public'
        Storage::fake('public');

        // Cria arquivo fake
        $file = UploadedFile::fake()->create('livro.pdf', 100, 'application/pdf');

        // Executa o POST com dados e arquivo
        $response = $this->postJson('/api/zapier/googleDriveFileUpload', [
            'event' => 'new_file',
            'title' => 'Meu Livro',
            'file' => $file,
        ],[
            'Authorization' => 'Bearer ' . $this->bearerToken,
        ]);

        // Verifica o retorno
        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Integração registrada com sucesso',
                 ]);

        // Verifica se o arquivo foi salvo
        Storage::disk('public')->assertExists($file->hashName());

        // Verifica se o registro foi criado
        $this->assertDatabaseHas('ZapierIntegration', [
            'NomeIntegracao' => 'ZapierGoogleDriveAPI',
            'Evento' => 'new_file',
            'Ativo' => true,
        ]);
    }

    /** @test */
    public function deve_salvar_teste_txt_quando_nao_houver_arquivo()
    {
        Storage::fake('public');

        $response = $this->postJson('/api/google-drive-upload', [
            'event' => 'sem_arquivo',
            'info' => 'teste sem arquivo',
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Integração registrada com sucesso',
                 ]);

        // Verifica se o arquivo teste.txt foi criado
        Storage::disk('public')->assertExists('teste.txt');

        // Verifica se o registro foi criado no banco
        $this->assertDatabaseHas('ZapierIntegration', [
            'Evento' => 'sem_arquivo',
        ]);
    }
}
