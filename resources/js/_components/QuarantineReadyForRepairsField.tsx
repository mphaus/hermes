import { SharedData } from "@/types";
import { usePage } from "@inertiajs/react";
import { Info } from "lucide-react";

export default function QuarantineReadyForRepairsField() {
    const { min_date, max_date } = usePage<SharedData>().props;

    return (
        <div className="space-y-4">
            <label htmlFor="starts_at" className="block font-semibold">{ 'Ready for repairs' }</label>
            <div className="flex items-start gap-1 mt-2">
                <Info size={ 16 } className="text-secondary shrink-0" />
                <p className="text-xs">{ 'Set the date this Product is expected to be in the warehouse, available for Repairs Technicians to work on. If the faulty Product is already in the Warehouse and is about to be placed on Quarantine Intake shelves, leave the date as today\'s.' }</p>
            </div>
            <input
                type="date"
                name="starts_at"
                id="starts_at"
                className="input"
                min={ min_date as string }
                max={ max_date as string }
            />
        </div>
    );
}
