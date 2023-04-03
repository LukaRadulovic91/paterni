<?php

///Builder dizajn pattern u Laravelu se može koristiti kada se želi
///  izgraditi složen objekat koji se sastoji od mnogih delova.
///  Ovaj pattern se koristi kada postoji potreba da se kreira objekat
///  korak po korak, prilagođen specifičnim zahtevima ili parametrima.
//
//Najčešće se koristi kada se radi sa složenim formama ili kada se
// kreira upit za bazu podataka sa mnogo filtera i parametara.
// Ovaj pattern nam omogućava da izgradimo objekat korak po korak,
// a da se ne brinemo o detaljima svakog koraka.
//
//U Laravelu, Builder pattern se često koristi u okviru Query Builder-a,
// gde se koriste različiti metodi za kreiranje SQL upita, koji se kasnije
// izvršavaju nad bazom podataka.
//
//Primer koriscenja Builder patterna u Laravelu može biti izgradnja složenog
// upita nad bazom podataka korak po korak. Na primer, možemo kreirati
// QueryBuilder objekat, dodati filtere i sortiranja, a zatim izvršiti upit
// i dobiti rezultat.


// Kreiramo interfejs Builder koji će biti implementiran od strane svih konkretnih buildera
interface Builder
{
    public function setCustomer(string $name, string $address): Builder;

    public function addProduct(int $id, int $quantity): Builder;

    public function get(): Order;
}

// Kreiramo konkretni Builder koji implementira Builder interfejs i gradi objekte klase Order
class OrderBuilder implements Builder
{
    private $order;

    public function __construct()
    {
        $this->order = new Order();
    }

    public function setCustomer(string $name, string $address): Builder
    {
        $this->order->setCustomer($name, $address);
        return $this;
    }

    public function addProduct(int $id, int $quantity): Builder
    {
        $this->order->addProduct($id, $quantity);
        return $this;
    }

    public function get(): Order
    {
        return $this->order;
    }
}

// Kreiramo klasu koju gradimo
class Order
{
    private $customerName;
    private $customerAddress;
    private $products = [];

    public function setCustomer(string $name, string $address)
    {
        $this->customerName = $name;
        $this->customerAddress = $address;
    }

    public function addProduct(int $id, int $quantity)
    {
        $this->products[$id] = $quantity;
    }

    public function getCustomerName(): string
    {
        return $this->customerName;
    }

    public function getCustomerAddress(): string
    {
        return $this->customerAddress;
    }

    public function getProducts(): array
    {
        return $this->products;
    }
}

// Koristimo Builder za kreiranje objekta klase Order
$order = (new OrderBuilder())
    ->setCustomer('Marko Markovic', 'Neka adresa 123')
    ->addProduct(1, 2)
    ->addProduct(3, 1)
    ->get();


