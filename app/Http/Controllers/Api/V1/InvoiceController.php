<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\InvoiceStoreRequest;
use App\Http\Requests\Api\V1\InvoiceUpdateRequest;
use App\Http\Resources\V1\InvoiceResource;
use App\Models\Invoice;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    use HttpResponses;
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only(['index', 'store', 'update', 'destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // return InvoiceResource::collection(
        //     Invoice::where([
        //         ['amount', '>', 950],
        //         ['paid', '=', true]
        //     ])->with('user')->get()
        // );

        return (new Invoice())->filter($request);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InvoiceStoreRequest $request)
    {
        if (!auth()->user()->tokenCan('invoice-store')) {
            return $this->error('Usuário não autorizado', 401);
        }
        try {
            $invoice = Invoice::create($request->validated());
            $invoice = new InvoiceResource($invoice->load('user'));
            return $this->success('Fatura criada com sucesso!', 200, $invoice);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        return new InvoiceResource($invoice);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InvoiceUpdateRequest $request, Invoice $invoice)
    {
        if (!auth()->user()->tokenCan('invoice-update')) {
            return $this->error('Usuário não autorizado', 401);
        }
        try {
            $invoice->update($request->validated());
            $invoice = new InvoiceResource($invoice->load('user'));
            return $this->success('Fatura atualizada com sucesso!', 200, $invoice);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        if (!auth()->user()->tokenCan('invoice-destroy')) {
            return $this->error('Usuário não autorizado', 401);
        }
        try {
            $invoice->delete();
            return $this->success('Fatura excluída com sucesso!', 200);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }
}
