import Carrusel from "@/components/carrusel";
import ListInstitutions from "@/components/list-institutions";
import Navbar from "@/components/navbar";

export default function Homepage() {
    const propsNavbar = {
        profileImage: "/imagenes/Item.png",
    }
    const propsTargetInstitucion = {
        backgroundImage: "/imagenes/FondoUniversidad.jpg",
        icon: "/imagenes/ItemUniversidad.png",
        name: "Universidad del Valle",
        enrolled: 199,
    };
    return (
        <>
            <Navbar props={propsNavbar} />
            <Carrusel className="w-full mt-4 max-w-[1050px] h-[350px]"
                imagenes={[
                    "https://i.pinimg.com/736x/7f/ff/2b/7fff2be551c4e31b0bd1c648b10d2cb0.jpg",
                    "https://i.pinimg.com/736x/2a/9b/c1/2a9bc109983886b44ec21e21bf94ac51.jpg",
                    "https://i.pinimg.com/736x/b9/4b/41/b94b4168c6bd760c5364d5d0709be7da.jpg",
                    "https://i.pinimg.com/736x/e4/b0/d2/e4b0d2abea6b83c341e88af0cb57b264.jpg",
                    "https://i.pinimg.com/736x/e3/a9/65/e3a9657ada1a40d273e9ded3d111a7bd.jpg",
                ]}
                numSlide={2}>
            </Carrusel>
            <ListInstitutions />
        </>
    )
}