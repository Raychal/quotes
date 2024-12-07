export default function Index({ data }) {
    const imageUrl = '/assets/first.png';
    return (
        <>
            <div className="bg-white text-white">
                <section 
                    className="background-container" 
                    style={{ backgroundImage: `url(${imageUrl})` }}
                >
                    <div className="text-overlay">
                        <p>{data.content}</p>
                        <span>- {data.author}</span>
                    </div>
                </section>
                <section className="items-center justify-center px-[130px] py-[165px] text-white bg-[#020202]">
                    <div className="text-5xl mb-[46px]">Feel free to contribute, whether by improving the design or fixing minor bugs, and use this API for building apps or learning as long as the service is online.</div>
                    <div className="flex justify-between items-center">
                        <div className="flex justify-between gap-10">
                            <a className="py-4 rounded-lg text-center bg-[#1A86BA] w-[150px] h-[55px]" href="/docs/api">docs</a>
                            <a className="py-3 rounded-lg text-center w-[150px] h-[55px] border-2 border-white" href="https://github.com/Raychal/quotes/blob/main/CONTRIBUTING.md">contribute</a>
                        </div>
                        <img src="/assets/second.png" alt="second" />
                    </div>
                </section>
            </div>
        </>
    );
}
