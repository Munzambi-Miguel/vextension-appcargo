<?php

namespace AppCargo\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorDataRequest;
use AppCargo\App\Modules\Cargo;
use Illuminate\Http\Request;
use Illuminate\Support\Fluent;
use Inertia\Inertia;

class AppCargoController extends Controller
{
    /**
     * Exibe a página inicial do componente.
     */
    public function index(Request $request)
    {
        $screenHeight = $request->header('Screen-Height', 800);
        $itemHeight = 35;

        $itemsPerPage = (int) floor($screenHeight / $itemHeight);

        $cargos = Cargo::search($request->search)->paginate($itemsPerPage);
        return Inertia::render('Packages/app-cargos/Components/TableAppCargo', compact('cargos'));
    }

    public function store(StorDataRequest $req)
    {
        $constData = new Fluent($req->heard_data);

        $this->columns = $req->heard_data['content'];
        unset($this->columns['tbl_name']);
        $this->columns['uid'] = $constData->uuid;
        if ($constData->uuid == "null") {
            $this->columns['uid'] = null;
        }

        $data = Cargo::createData($this->columns);
        return redirect()->route('AppCargo.index', ['key' => \Str::limit($data[$req->heard_data['key']], 20), 'mltUd' => $data[$req->heard_data['uid']]])->with([
            'success' => 'Post created successfully!',
            'objectKey' => $data[$req->heard_data['key']],
            'infoData' => $data[$req->heard_data['uid']],
        ]);
    }

}
