import routes from "~/assets/json/routes/routes.json";

export default function ({ store, redirect }) {
    let roles = store.state.auth.user.roles.map(role => role.name);
    if (roles.includes('admin')) { return redirect('/admin/bank');}
    if (roles.includes('client')) { return redirect('/user/wallet');}
    return redirect('/auth/signin');
}
