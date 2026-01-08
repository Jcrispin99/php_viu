<?php
/**
 * Test script for all models
 * Run this file to verify all models are working correctly
 * 
 * Usage: php app/tests/test_models.php
 */

require_once __DIR__ . '/../models/Platform.php';
require_once __DIR__ . '/../models/Actor.php';
require_once __DIR__ . '/../models/Director.php';
require_once __DIR__ . '/../models/Idioma.php';
require_once __DIR__ . '/../models/Serie.php';

echo "========================================\n";
echo "  TESTING ALL MODELS\n";
echo "========================================\n\n";

// Test Platform
echo "1. Testing Platform Model:\n";
echo "----------------------------\n";
try {
    $platforms = Platform::getAll();
    echo "✅ Platform::getAll() - Found " . count($platforms) . " platforms\n";
    foreach ($platforms as $p) {
        echo "   - ID: {$p->getId()}, Name: {$p->getName()}\n";
    }
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
echo "\n";

// Test Actor
echo "2. Testing Actor Model:\n";
echo "----------------------------\n";
try {
    $actores = Actor::getAll();
    echo "✅ Actor::getAll() - Found " . count($actores) . " actores\n";
    foreach ($actores as $a) {
        echo "   - ID: {$a->getId()}, Name: {$a->getNombre()} {$a->getApellidos()}\n";
    }
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
echo "\n";

// Test Director
echo "3. Testing Director Model:\n";
echo "----------------------------\n";
try {
    $directores = Director::getAll();
    echo "✅ Director::getAll() - Found " . count($directores) . " directores\n";
    foreach ($directores as $d) {
        echo "   - ID: {$d->getId()}, Name: {$d->getNombre()} {$d->getApellidos()}\n";
    }
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
echo "\n";

// Test Idioma
echo "4. Testing Idioma Model:\n";
echo "----------------------------\n";
try {
    $idiomas = Idioma::getAll();
    echo "✅ Idioma::getAll() - Found " . count($idiomas) . " idiomas\n";
    foreach ($idiomas as $i) {
        echo "   - ID: {$i->getId()}, Name: {$i->getNombre()}, ISO: {$i->getIsoCode()}\n";
    }
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
echo "\n";

// Test Serie
echo "5. Testing Serie Model:\n";
echo "----------------------------\n";
try {
    $series = Serie::getAll();
    echo "✅ Serie::getAll() - Found " . count($series) . " series\n";
    foreach ($series as $s) {
        echo "   - ID: {$s->getId()}, Title: {$s->getTitulo()}\n";
        echo "     Platform ID: {$s->getPlataformaId()}, Director ID: {$s->getDirectorId()}\n";
        
        // Test relationships
        $actores = Serie::getActores($s->getId());
        echo "     Actores (" . count($actores) . "): ";
        foreach ($actores as $a) {
            echo "{$a->getNombre()} {$a->getApellidos()}, ";
        }
        echo "\n";
        
        $audios = Serie::getIdiomasAudio($s->getId());
        echo "     Audio (" . count($audios) . "): ";
        foreach ($audios as $i) {
            echo "{$i->getNombre()} ({$i->getIsoCode()}), ";
        }
        echo "\n";
        
        $subs = Serie::getIdiomasSubtitulos($s->getId());
        echo "     Subtitles (" . count($subs) . "): ";
        foreach ($subs as $i) {
            echo "{$i->getNombre()} ({$i->getIsoCode()}), ";
        }
        echo "\n\n";
    }
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\n========================================\n";
echo "  TESTING COMPLETED\n";
echo "========================================\n";
