<?php

namespace App\Utils;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait CanRate
{
    public function ratings($model = null): MorphToMany
    {
        $modelClass = $model ? $model : $this->getMorphClass();

        $morphToMany = $this->morphToMany(
            $modelClass, // Nombre de clase del modelo con el que se quiere tener relación
            'qualifier', // Nombre de las columnas del modelo actual en la tabla pivote
            'ratings', // Nombre de la tabla pivote
            'qualifier_id', // Llave foránea del modelo actual en la tabla pivote
            'rateable_id' // Llave foránea del modelo con el que se va a tener relación en la tabla pivote
        );

        $morphToMany
            ->as('rating') // Alias de la relación con la tabla pivote
            ->withTimestamps() // Función para que Eloquent se encargue de mantener los timestamps
            ->withPivot('score', 'rateable_type') // Columnas adicionales de la tabla pivote
            ->wherePivot('rateable_type', $modelClass) // Where dentro de la tabla pivote
            ->wherePivot('qualifier_type', $this->getMorphClass()); // Where dentro de la tabla pivote

        return $morphToMany;
    }

    public function rate(Model $model, float $score): bool
    {
        if ($this->hasRated($model)) {
            return false;
        }

        $this->ratings($model)->attach($model->getKey(), [
            'score' => $score,
            'rateable_type' => get_class($model)
        ]);

        return true;
    }

    public function unrate(Model $model): bool
    {
        if (!$this->hasRated($model)) {
            return false;
        }

        $this->ratings($model->getMorphClass())->detach($model->getKey());

        return true;
    }

    public function hasRated(Model $model): bool
    {
        return !is_null($this->ratings($model)->find($model->getKey()));
    }
}
