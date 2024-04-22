import React from "react";

function Home() {
  return (
    <>
      <div className="container">
        <div className="recom">
          <div className="section headline">
            <h4>Recommendation</h4>
          </div>
          <div className="section scrollList">
            <img
              src="https://i.compasspub.com/userfiles/item/20231122132720_itm.png"
              alt=""
            />
            <img
              src="https://i.compasspub.com/userfiles/item/20231117142036_itm.png"
              alt=""
            />
            <img
              src="https://i.compasspub.com/userfiles/item/2023080994546_itm.png"
              alt=""
            />
            <img
              src="https://i.compasspub.com/userfiles/item/2023102511058_itm.jpg"
              alt=""
            />
            <img
              src="https://i.compasspub.com/userfiles/item/20231212145035_itm.jpg"
              alt=""
            />
            <img
              src="https://i.compasspub.com/userfiles/item/20231212144942_itm.jpg"
              alt=""
            />
          </div>
        </div>
        <div className="section"></div>
        <div className="about">
          <div className="section headline">
            <h4>Publication</h4>
          </div>
          <div className="section">
            <p>
              In 1999, Compass Publishing published its inaugural textbook
              English for Everyday Activity, commencing our journey into the in
              ELT Publishing market. Since that first step, we have stayed
              committed to our philosophy of "English Education for a better
              life". We hold this belief to be true as it has motivated us to
              continuously develop quality academic matterials.
            </p>
          </div>
        </div>
        <div className="section partner">
          <div className="section headline">
            <h4>Partnership</h4>
          </div>
          <div className="section thumbs">
            <img
              src="https://www.wjcompass.com/eng/front/image/main/btn_menu01_on.png"
              alt=""
            />
            <img
              src="https://www.wjcompass.com/kor/front/image/main/btn_menu02_on.png"
              alt=""
            />
            <img
              src="https://www.wjcompass.com/kor/front/image/main/btn_menu03_on.png"
              alt=""
            />
          </div>
        </div>
        <div className="section"></div>
      </div>
    </>
  );
}

export default Home;
