<?php

namespace App\Services;

use App\Models\Inventory;

class KardexService
{
    public function getLastRecord($productId,$warehouseId){
        $lastRecord= Inventory::where('product_id',$productId)
            ->where('warehouse_id', $warehouseId)
            ->latest('id')
            ->first();
        return [
            'quantity'=> $lastRecord?->quantity_balance ?? 0,
            'cost'=> $lastRecord?->cost_balance ?? 0,
            'total'=> $lastRecord?->total_balance ?? 0,
            'date'=> $lastRecord?->created_at ?? null,
        ];
    }


    public function registerEntry($model, array $product, $warehouseId,$detail){
        $lastRecord = $this->getLastRecord($product['id'],$warehouseId);

        $newQuantityBalance = $lastRecord['quantity'] + $product['quantity'];
        $newTotalBalance = $lastRecord['total'] + ($product['quantity'] * $product['price']);
        $newCostBalance = $newTotalBalance/($newQuantityBalance ?: 1);
        
        $model->inventories()->create([
            'detail'=>$detail,
            'quantity_in'=> $product['quantity'],
            'cost_in'=>$product['price'],
            'total_in'=>$product['quantity']*$product['price'],
            'quantity_balance'=>$newQuantityBalance,
            'cost_balance'=>$newCostBalance,
            'total_balance'=>$newTotalBalance,
            'product_id'=>$product['id'],
            'warehouse_id'=>$warehouseId,
        ]);
    }

    
    public function registerExit($model, array $product, $warehouseId,$detail){
        // $lastRecord = $this->getLastRecord($product['id'],$warehouseId);
        
        // $newQuantityBalance = $lastRecord['quantity'] - $product['quantity'];

        // $newTotalBalance = $lastRecord['total'] - ($product['quantity'] * $product['price']);
        // $newCostBalance = $newTotalBalance/($newQuantityBalance ?: 1);
        
        // $model->inventories()->create([
        //     'detail'=>$detail,
        //     'quantity_out'=> $product['quantity'],
        //     'cost_out'=>$product['price'],
        //     'total_out'=>$product['quantity']*$lastRecord['price'],
        //     'quantity_balance'=>$newQuantityBalance,
        //     'cost_balance'=>$newCostBalance,
        //     'total_balance'=>$newTotalBalance,
        //     'product_id'=>$product['id'],
        //     'warehouse_id'=>$warehouseId,
        // ]);
        $lastRecord = $this->getLastRecord($product['id'], $warehouseId);

        // Validar que hay stock suficiente
        if ($lastRecord['quantity'] < $product['quantity']) {
            throw new \Exception("No hay suficiente stock para el producto ID {$product['id']}");
        }


        // Calcular nuevos saldos
        $newQuantityBalance = $lastRecord['quantity'] - $product['quantity'];
        $newTotalBalance =$lastRecord['total'] - ($product['quantity'] * $product['price']);
        $newCostBalance = $newQuantityBalance > 0 
            ? $newTotalBalance / $newQuantityBalance 
            : 0;

        // Registrar movimiento
        $model->inventories()->create([
            'detail' => $detail,
            'quantity_out' => $product['quantity'],
            'cost_out' => $product['price'],
            'total_out' => $product['quantity']*$product['price'],
            'quantity_balance' => $newQuantityBalance,
            'cost_balance' => $newCostBalance,
            'total_balance' => $newTotalBalance,
            'product_id' => $product['id'],
            'warehouse_id' => $warehouseId,
        ]);



    }

    

}