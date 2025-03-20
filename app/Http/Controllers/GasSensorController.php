<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GasSensor;

class GasSensorController extends Controller
{
    // 1️⃣ Récupérer la dernière valeur du capteur
    public function getGazLevel() {
        dd($request->all());
        return GasSensor::latest()->first();
    }

    // 2️⃣ Enregistrer une nouvelle valeur envoyée par l'ESP32
    public function getGazLevel() {
        $latestGasLevel = GasSensor::latest()->first();
        return response()->json($latestGasLevel);
    }

    // 3️⃣ Vérifier si le niveau dépasse le seuil
    private function checkThreshold($value) {
        $threshold = 100; // Seuil critique
        return $value > $threshold;
    }

    // 4️⃣ Envoyer une alerte en cas de dépassement du seuil
    private function sendAlert($value) {
        // Logique d'alerte (email, notification, webhook...)
        \Log::warning("⚠️ Alerte : Niveau de gaz élevé détecté ($value) !");
    }
}
