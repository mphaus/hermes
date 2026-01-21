import UsersList from "@/_components/UsersList";
import { SharedData, UsersData } from "@/types";
import { Head, usePage } from "@inertiajs/react";

export default function UserIndex() {
    const { title } = usePage<SharedData>().props;
    const usersData = usePage<SharedData>().props.users_data as UsersData;
    const { data: users } = usersData;


    return (
        <>
            <Head title={title} />
            <UsersList users={users} />
        </>
    );
}
