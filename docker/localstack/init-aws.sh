#!/bin/bash

# Initialize LocalStack services to simulate AWS
# This script runs when LocalStack container starts

echo "Initializing LocalStack services..."

# Wait for LocalStack to be ready (poll until awslocal works)
echo "Waiting for LocalStack to be ready..."
RETRIES=0
MAX_RETRIES=30
until awslocal s3 ls >/dev/null 2>&1; do
	sleep 2
	RETRIES=$((RETRIES+1))
	echo "Waiting for LocalStack s3... attempt $RETRIES"
	if [ "$RETRIES" -ge "$MAX_RETRIES" ]; then
		echo "LocalStack did not become ready after $MAX_RETRIES attempts" >&2
		exit 1
	fi
done

# Create S3 bucket for employee documents and evaluations (idempotent)
echo "Creating S3 buckets..."
awslocal s3 mb s3://pid-evaluation-documents || true
awslocal s3 mb s3://pid-evaluation-reports || true

# Set bucket policies (make them accessible)
awslocal s3api put-bucket-acl --bucket pid-evaluation-documents --acl public-read || true
awslocal s3api put-bucket-acl --bucket pid-evaluation-reports --acl public-read || true

echo "S3 buckets created or already exist: pid-evaluation-documents, pid-evaluation-reports"

# Note: API Gateway setup would typically be done via AWS SAM or Terraform
# For this simulation, the backend service will handle API routing

echo "LocalStack initialization complete!"
