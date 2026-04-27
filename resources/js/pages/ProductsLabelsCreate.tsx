import { Printer, Search, X } from "lucide-react";

const products = [
    {
        id: 1,
        name: "Classic Mug",
        image: "https://placehold.co/80x80?text=Mug",
    },
    {
        id: 2,
        name: "Notebook Pro very long text name for this product in purpose just to test the layout",
        image: "https://placehold.co/80x80?text=Book",
    },
    {
        id: 3,
        name: "Desk Lamp",
        image: "https://placehold.co/80x80?text=Lamp",
    },
    {
        id: 4,
        name: "Travel Bottle",
        image: "https://placehold.co/80x80?text=Bottle",
    },
    {
        id: 5,
        name: "Wireless Mouse",
        image: "https://placehold.co/80x80?text=Mouse",
    },
    {
        id: 6,
        name: "Keyboard Case",
        image: "https://placehold.co/80x80?text=Case",
    },
    {
        id: 7,
        name: "Coffee Grinder",
        image: "https://placehold.co/80x80?text=Grind",
    },
    {
        id: 8,
        name: "Bluetooth Speaker",
        image: "https://placehold.co/80x80?text=Sound",
    },
    {
        id: 9,
        name: "Phone Stand",
        image: "https://placehold.co/80x80?text=Stand",
    },
    {
        id: 10,
        name: "Waterproof Bag",
        image: "https://placehold.co/80x80?text=Bag",
    },
    {
        id: 11,
        name: "Smart Charger",
        image: "https://placehold.co/80x80?text=Charge",
    },
    {
        id: 12,
        name: "Mini Projector",
        image: "https://placehold.co/80x80?text=Beam",
    },
    {
        id: 13,
        name: "Canvas Backpack",
        image: "https://placehold.co/80x80?text=Pack",
    },
    {
        id: 14,
        name: "Studio Headphones",
        image: "https://placehold.co/80x80?text=Audio",
    },
];

export default function ProductsLabelsCreate() {
    return (
        <>
            <div className="md:grid md:gap-4 md:grid-cols-3 md:items-start xl:grid-cols-4">
                <div className="space-y-4 md:col-span-2 xl:col-span-3">
                    <label htmlFor="" className="input">
                        <Search />
                        <input
                            type="search"
                            name=""
                            id=""
                            placeholder={'Search for products...'}
                        />
                    </label>
                    <ul className="shadow-sm list bg-base-100 rounded-box">
                        <li className="flex items-center justify-between gap-2 p-4 bg-base-200">
                            <span className="opacity-60">{`Selected products (${products.length})`}</span>
                            <button className="btn btn-ghost btn-sm">{'Clear all'}</button>
                        </li>
                        {products.map((product) => (
                            <li key={product.id} className="items-center list-row">
                                <div><img className="size-10 rounded-box" src={product.image} alt={product.name} /></div>
                                <div>{product.name}</div>
                                <button className="btn btn-square btn-ghost">
                                    <X size={16} />
                                </button>
                            </li>
                        ))}
                    </ul>
                </div>
                <div className="hidden shadow-sm card bg-base-100 md:block card-sm">
                    <div className="card-body">
                        <h2 className="card-title">{'Generate'}</h2>
                        <p>{'According to the product specifications in CurrentRMS, four types of labels can be generated:'}</p>
                        <ul className="pl-10 font-semibold list-disc">
                            <li>{'Tub labels'}</li>
                            <li>{'Nally bin labels - Standard'}</li>
                            <li>{'Nally bin labels - Stored at height'}</li>
                            <li>{'Colour-coded labels'}</li>
                        </ul>
                        <button type="button" className="mt-4 btn btn-primary btn-block">
                            <Printer size={16} />
                            <span>{'Generate labels'}</span>
                        </button>
                    </div>
                </div>
            </div>
            <div className="fixed z-10 inset-x-4 bottom-4 md:hidden">
                <button type="button" className="btn btn-primary btn-lg btn-block">
                    <Printer size={16} />
                    <span>{'Generate labels'}</span>
                </button>
            </div>
        </>
    );
}