import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
	static targets = ["tabLink", "tabContent"];

	connect() {
		
	}

	selectTab(event) {
		event.preventDefault();
		const targetId = event.currentTarget.getAttribute("data-tab-target");
		const tabContent = this.findTabContent(targetId);
		this.tabContentTargets.forEach((tab) => {
			tab.removeAttribute("active");
		});
		this.tabLinkTargets.forEach((tab) => {
			tab.children[0].removeAttribute("active");
		});

		event.currentTarget.children[0].setAttribute("active", "");
		tabContent.setAttribute("active", "");
	}
	
	findTabContent(targetId) {
		return this.tabContentTargets.find((content) => content.id === targetId);
	}
}
