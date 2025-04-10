<?php

namespace AppCargo\App\Modules;

use App\Http\API\CodeController;
use App\Models\Trait\ArrayColores;
use App\Models\Trait\Search;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Fluent;

/**
 * @method static paginate(int $itemsPerPage)
 * @method static search(mixed $search)
 */
class Cargo extends Model
{
    use Search;

    protected $table = 'cargos';

    protected $fillable = [
        'uid',
        'codigo',
        'designacao',
        'colorContext',
        'detalhes',
    ];

    protected $searchable = ['codigo', 'designacao', 'detalhes'];

    public static function createData($data): self
    {
        $attribute = new Fluent($data);
        if ($attribute->uid) {
            $ttr = self::where('uid', $data['uid'])->first();
            $ttr->update($data);
            return $ttr;
        }

        return self::create($data);
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->uuid) {
                $model->uid = uuid_create();
                if (is_null($model->codigo)) {
                    $model->codigo = CodeController::generateUniqueCodeUtil('Cargo');
                }
            }

            $model->status = 1;

            $model->tbl_name = 'cargo';
            $randomStatus = ArrayColores::$statusOptions[array_rand(ArrayColores::$statusOptions)]['id'];
            $model->colorContext = $randomStatus;
        });
    }
}
