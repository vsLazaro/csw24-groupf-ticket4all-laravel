deploy:
	php artisan config:clear
	sam package --output-template-file .stack.yaml --region us-east-1 --s3-bucket {BUCKET}
	sam deploy  --template-file .stack.yaml --capabilities CAPABILITY_IAM --region us-east-2 --stack-name laravel-bref-demo-1