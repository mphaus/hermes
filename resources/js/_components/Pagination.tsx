import { PaginationLink as PaginationLinkType } from "@/types";
import PaginationLink from "./PaginationLink";

export default function Pagination({ links }: {
    links: PaginationLinkType[];
}) {
    return (
        <div className="join flex-wrap flex justify-center md:justify-end">
            {links.map(link => <PaginationLink key={link.label} link={link} />)}
        </div>
    );
}
