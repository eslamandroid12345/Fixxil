<?php

namespace App\Repository;

interface OrderRepositoryInterface extends RepositoryInterface
{
    public function getAllOrderDashboard($status,$rank);
    public function getOrderHasOffers();
    public  function getOrderForUser($id,$status);
    public  function getNewOrderForProviderHome();
    public  function getOrderForProvider($id,$status);
//    public  function getInprogressOrderForProvider($id);
//    public  function getFinishedOrderForProvider($id);
    public  function getOrderNotHavOffer($id);
    public  function getOrdersForCustomer($id,$status);
//    public  function getInprogressOrderForCustomer($id);
//    public  function getFinishedOrderForCustomer($id);
    public function getAllOrderFinishedProvider($id);

    public function getAllOrdersComplaint($id);

    public function getOrdersForProvider($id);
    public function getLastOrders();

}
