import { SharedData } from "@/types";
import { usePage } from "@inertiajs/react";

export default function DrawerDescription() {
    const { description } = usePage<SharedData>().props;

    if (!description) {
        return null;
    }

    return (
        <div
            dangerouslySetInnerHTML={ { __html: description } }
            className="p-4 text-sm bg-base-100"
        ></div>
    );
}
