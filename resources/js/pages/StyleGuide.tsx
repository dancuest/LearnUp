import Carrusel from "@/components/carrusel";

export default function StyleGuide() {

    return (<div className="flex min-h-screen flex-col items-start p-6 text-[#1b1b18] lg:justify-start lg:p-8 dark:bg-[#0a0a0a]">
        <h1>Style Guide</h1>
        <p>This is a style guide for the application.</p>
        <h2>Colors</h2>
        <ul>
            <li className="w-min bg-[#FF5733]"> #FF5733</li>
            <li className="w-min bg-[#33FF57]"> #33FF57</li>
            <li className="w-min bg-[#3357FF]"> #3357FF</li>
        </ul>
        <h2>Typography</h2>
        <p>This is a sample paragraph to demonstrate typography.</p>
        <Carrusel className="w-full max-w-[1000px] h-[300px]"
            imagenes={[
                "https://i.pinimg.com/736x/7f/ff/2b/7fff2be551c4e31b0bd1c648b10d2cb0.jpg",
                "https://i.pinimg.com/736x/2a/9b/c1/2a9bc109983886b44ec21e21bf94ac51.jpg",
                "https://i.pinimg.com/736x/b9/4b/41/b94b4168c6bd760c5364d5d0709be7da.jpg",
                "https://i.pinimg.com/736x/e4/b0/d2/e4b0d2abea6b83c341e88af0cb57b264.jpg",
                "https://i.pinimg.com/736x/e3/a9/65/e3a9657ada1a40d273e9ded3d111a7bd.jpg",
            ]}
            numSlide={2}>
        </Carrusel>
    </div >)
}