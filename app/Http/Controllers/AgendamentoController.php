<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agendamento;

class AgendamentoController extends Controller
{
    public function index()
    {
        $agendamentos = Agendamento::all();
        return response()->json($agendamentos);
    }

    public function show($id)
    {
        $agendamento = Agendamento::find($id);

        if (!$agendamento) {
            return response()->json(['message' => 'Agendamento não encontrado'], 404);
        }

        return response()->json($agendamento);
    }

    public function getAll()
    {
        $agendamentos = Agendamento::all();

        $agendamentosFormatted = $agendamentos->map(function ($agendamento) {
            return [
                'id' => $agendamento->id,
                'usuario_id' => $agendamento->usuario_id,
                'hora_inicio' => $agendamento->hora_inicio,
                'hora_fim' => $agendamento->hora_fim,
                'data' => $agendamento->data->format('Y-m-d'), // Formato da data
                'avaliacao' => $agendamento->avaliacao,
                'dia' => $agendamento->data->format('d'),
                'mes' => $agendamento->data->format('m'),
                'ano' => $agendamento->data->format('Y'),
            ];
        });

        return response()->json($agendamentosFormatted);
    }


    public function store(Request $request)
    {
        $request->validate([
            'usuario_id' => 'required|uuid',
            'hora_inicio' => 'required|string|size:2',
            'hora_fim' => 'required|string|size:2',
            'data' => 'required|date',
            'avaliacao' => 'nullable|integer',
        ]);

        $agendamento = Agendamento::create($request->all());

        return response()->json($agendamento, 201);
    }

    public function update(Request $request, $id)
    {
        $agendamento = Agendamento::find($id);
    
        if (!$agendamento) {
            return response()->json(['message' => 'Agendamento não encontrado'], 404);
        }
    
        $request->validate([
            'hora_inicio' => 'nullable|string',
            'hora_fim' => 'nullable|string',
            'data' => 'nullable|date',
            'avaliacao' => 'nullable|integer',
            'usuario_id' => 'nullable|string'
        ]);
    
        $agendamento->update($request->only([
            'hora_inicio', 'hora_fim', 'data', 'avaliacao', 'usuario_id'
        ]));
    
        // Retornar o agendamento atualizado como JSON
        return response()->json($agendamento);
    }
    
    public function destroy($id)
    {
        $agendamento = Agendamento::find($id);

        if (!$agendamento) {
            return response()->json(['message' => 'Agendamento não encontrado'], 404);
        }

        $agendamento->delete();

        return response()->json(['message' => 'Agendamento deletado com sucesso']);
    }
}
