import { useTranslation } from 'react-i18next';

export const Token = code => {
	const { t } = useTranslation();

	return t(code);
}