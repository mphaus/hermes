import { PaginationLink as PaginationLinkType } from "@/types";
import { Link } from "@inertiajs/react";
import clsx from "clsx";

export default function PaginationLink({ link }: {
    link: PaginationLinkType;
}) {
    if (link.url === null) {
        return (
            <span className="join-item btn btn-disabled btn-sm btn-ghost" dangerouslySetInnerHTML={{ __html: link.label }}></span>
        );
    }

    return (
        <Link href={link.url} className={clsx({
            'join-item btn btn-sm btn-ghost': true,
            'btn-primary font-semibold': link.active,
        })} dangerouslySetInnerHTML={{ __html: link.label }}></Link>
    );
}
