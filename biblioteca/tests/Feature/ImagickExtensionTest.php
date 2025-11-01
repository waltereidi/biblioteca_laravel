<?php

namespace Tests\Feature;

use Tests\TestCase;
use Imagick;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ImagickExtensionTest extends TestCase
{
    /**
     * Testa a geração de uma thumbnail da capa (primeira página) de um PDF.
     *
     * Requer:
     *  - Extensão imagick instalada e com suporte a PDF (Ghostscript)
     *  - Arquivo tests/Files/sample.pdf
     */
    public function test_can_generate_thumbnail_from_pdf_cover(): void
    {
        if (!extension_loaded('imagick')) {
            $this->markTestSkipped('A extensão Imagick não está habilitada.');
        }

        // Caminho do PDF de teste
        $pdfPath = base_path('tests/Files/Energia e Civilizacao_ Uma Historia - Vaclav Smil.pdf');
        $this->assertFileExists($pdfPath, "O arquivo PDF não foi encontrado em {$pdfPath}");

        // Caminho de saída (Laravel Storage temporário)
        $outputDir = storage_path('tests/Files');
        File::ensureDirectoryExists($outputDir);

        $thumbnailPath = $outputDir . '/sample_cover_thumbnail.jpg';

        try {
            // 1️⃣ Cria uma instância Imagick com resolução de 150 DPI
            $imagick = new Imagick();
            $imagick->setResolution(150, 150);

            // 2️⃣ Lê apenas a primeira página [0] (capa)
            $imagick->readImage("{$pdfPath}[0]");

            // 3️⃣ Configura formato e fundo branco (evita transparência preta)
            $imagick->setImageFormat('jpeg');
            $imagick->setImageBackgroundColor('white');
            $imagick = $imagick->mergeImageLayers(Imagick::LAYERMETHOD_FLATTEN);

            // 4️⃣ Redimensiona mantendo proporção
            $imagick->thumbnailImage(300, 300, true);

            // 5️⃣ Salva no diretório de teste do Laravel
            $imagick->writeImage($thumbnailPath);
            $imagick->clear();
            $imagick->destroy();

            // 6️⃣ Verifica resultados
            $this->assertFileExists($thumbnailPath, 'O thumbnail não foi criado.');
            $this->assertGreaterThan(0, filesize($thumbnailPath), 'O thumbnail está vazio.');

            // 7️⃣ (Opcional) copia para o disco 'public' para inspeção manual
            Storage::disk('public')->put(
                'thumbnails/sample_cover_thumbnail.jpg',
                file_get_contents($thumbnailPath)
            );
            
            $this->assertTrue(Storage::disk('public')->exists('thumbnails/sample_cover_thumbnail.jpg'));

        } catch (\ImagickException $e) {
            $this->fail('Erro do Imagick: ' . $e->getMessage());
        } catch (\Exception $e) {
            $this->fail('Erro inesperado: ' . $e->getMessage());
        }
    }
}
