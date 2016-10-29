/**
 * ͼƬͷ���ݼ��ؾ����¼� - �����ȡͼƬ�ߴ�
 * @version	2011.05.27
 * @author	TangBin
 * @see		http://www.planeart.cn/?p=1121
 * @param	{String}	ͼƬ·��
 * @param	{Function}	�ߴ����
 * @param	{Function}	������� (��ѡ)
 * @param	{Function}	���ش��� (��ѡ)
 * @example imgReady('http://www.google.com.hk/intl/zh-CN/images/logo_cn.png', function () {
		alert('size ready: width=' + this.width + '; height=' + this.height);
	});
 */
var imgReady = (function () {
	var list = [], intervalId = null,

	// ����ִ�ж���
	tick = function () {
		var i = 0;
		for (; i < list.length; i++) {
			list[i].end ? list.splice(i--, 1) : list[i]();
		};
		!list.length && stop();
	},

	// ֹͣ���ж�ʱ������
	stop = function () {
		clearInterval(intervalId);
		intervalId = null;
	};

	return function (url, ready, load, error) {
		var onready, width, height, newWidth, newHeight,
			img = new Image();
		
		img.src = url;

		// ���ͼƬ�����棬��ֱ�ӷ��ػ�������
		if (img.complete) {
			ready.call(img);
			load && load.call(img);
			return;
		};
		
		width = img.width;
		height = img.height;
		
		// ���ش������¼�
		img.onerror = function () {
			error && error.call(img);
			onready.end = true;
			img = img.onload = img.onerror = null;
		};
		
		// ͼƬ�ߴ����
		onready = function () {
			newWidth = img.width;
			newHeight = img.height;
			if (newWidth !== width || newHeight !== height ||
				// ���ͼƬ�Ѿ��������ط����ؿ�ʹ��������
				newWidth * newHeight > 1024
			) {
				ready.call(img);
				onready.end = true;
			};
		};
		onready();
		
		// ��ȫ������ϵ��¼�
		img.onload = function () {
			// onload�ڶ�ʱ��ʱ��Χ�ڿ��ܱ�onready��
			// ������м�鲢��֤onready����ִ��
			!onready.end && onready();
		
			load && load.call(img);
			
			// IE gif������ѭ��ִ��onload���ÿ�onload����
			img = img.onload = img.onerror = null;
		};

		// ��������ж���ִ��
		if (!onready.end) {
			list.push(onready);
			// ���ۺ�ʱֻ�������һ����ʱ��������������������
			if (intervalId === null) intervalId = setInterval(tick, 40);
		};
	};
})();